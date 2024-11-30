from datetime import datetime, timedelta
from typing import Annotated
from dotenv import load_dotenv
import os

from fastapi import Depends, HTTPException, status
from fastapi.security import OAuth2PasswordBearer, OAuth2PasswordRequestForm
from fastapi.encoders import jsonable_encoder

from sqlalchemy import inspect
from sqlalchemy.orm import Session
from jose import JWTError, jwt
from passlib.context import CryptContext

from models.user import User, TokenTable
from database.crud import get_user
from schemas.user import UserSchema
from database.database import get_db

load_dotenv()

SECRET_KEY = os.getenv('AUTH_SECRET')
ALGORITHM = 'HS256'
ACCESS_TOKEN_EXPIRE_MINUTES = 60
REFRESH_TOKEN_EXPIRE_MINUTES = 60 * 24 * 7


oauth2_scheme = OAuth2PasswordBearer(tokenUrl='api/auth/login')

pwd_context = CryptContext(schemes=['bcrypt'], deprecated='auto')


def verify_password(plain_password, hashed_password):
    return pwd_context.verify(plain_password, hashed_password)

def get_password_hash(password):
    return pwd_context.hash(password)

def create_user(db: Session, user: UserSchema):

    if user.password == '':
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail='Password cannot be empty'
        )
    
    if user.first_name == "" or user.last_name == "":
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail='First name and last name cannot be empty'
        )
    
    if db.query(User).filter(User.email == user.email).first():
        raise HTTPException(
            status_code=status.HTTP_409_CONFLICT,
            detail='User already exists'
        )
    
    try:
        new_user = User(
            first_name = user.first_name,
            last_name = user.last_name,
            email = user.email,
            username = user.username,
            hashed_password = get_password_hash(user.password),
            bio = user.bio
        )
        db.add(new_user)
        db.commit()
        db.refresh(new_user)

        print(new_user)
        return jsonable_encoder(new_user)

    except Exception as e:
        print(e)
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail='Failed to create user'
        )


def create_access_token(data: dict, expires_delta: int | None = None):
    to_encode = data.copy()

    if expires_delta:
        expire = datetime.utcnow() + expires_delta
    else:
        expire = datetime.utcnow() + timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES)
    # print(to_encode)
    to_encode.update({'exp': expire, 'sub': str(data['id'])})
    encoded_jwt = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)

    return encoded_jwt

def create_refresh_token(data: dict, expires_delta: int | None = None):
    print(data)
    to_encode = data.copy()

    if expires_delta:
        expire = datetime.utcnow() + expires_delta
    else:
        expire = datetime.utcnow() + timedelta(days=REFRESH_TOKEN_EXPIRE_MINUTES)
    # print(to_encode)
    to_encode.update({'exp': expire, 'sub': str(data['id'])})
    encoded_jwt = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)

    return encoded_jwt

def object_as_dict(obj):
    return {
        c.key: getattr(obj, c.key)
        for c in inspect(obj).mapper.column_attrs
    }

def authenticate_user(username: str, password: str, db: Session):
    # print(username)
    user = get_user(db, username)
    if user is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail='User does not exist',
        )
    if not verify_password(password, user.hashed_password):
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail='Incorrect username or password',
        )
    
    return user
    # print(object_as_dict(user))
    access = create_access_token(
        data=object_as_dict(user),
    )
    refresh = create_refresh_token(
        data=object_as_dict(user),
    )

    token_db = TokenTable(user_id=user.id, access_toke=access, refresh_toke=refresh, status=True)
    
    db.add(token_db)
    db.commit()
    db.refresh(token_db)

    return {
        'access_token': access,
        'refresh_token': refresh,
    }

async def get_current_user(token: Annotated[str, Depends(oauth2_scheme)]):
    user = jwt.decode(token, SECRET_KEY, ALGORITHM)
    
    if user is None:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail='User does not exist',
            headers={"WWW-Authenticate": "Bearer"},
        )
    return user