from datetime import datetime, timedelta
from typing import Optional, Annotated
from fastapi import status, Depends, HTTPException, Header, APIRouter
from fastapi.security import OAuth2PasswordRequestForm
from sqlalchemy.orm import Session

from database.database import get_db

from models.user import User, TokenTable

from schemas.user import UserSchema, UpdateUserSchema, TokenSchema, UserLoginSchema

from responses.response import ResponseClass

from services.auth import create_user, create_access_token, get_current_user, authenticate_user, create_refresh_token, object_as_dict

ACCESS_TOKEN_EXPIRE_MINUTES = 60
REFRESH_TOKEN_EXPIRE_MINUTES = 60 * 24 * 7


router = APIRouter(prefix='/api/auth', tags=['Authentication'])

@router.post('/user/signup', response_model=ResponseClass, status_code=201)
async def signup(data: UserSchema, db: Session = Depends(get_db)):
    new_user = create_user(db, data)

    return ResponseClass(
        message='User registered successfully',
        statusCode=201,
        data=new_user
    )

# @router.post("/login", response_model=TokenSchema)
# async def login(request: UserLoginSchema = Depends(authenticate_user)):
#     print(request)
#     # user = authenticate_user(username=request.username, password=request.password)
#     # if not user:
#     #     raise HTTPException(
#     #         status_code=status.HTTP_401_UNAUTHORIZED,
#     #         detail="Incorrect username or password",
#     #         headers={"WWW-Authenticate": "Bearer"},
#     #     )
    
#     return request

@router.post('/login', response_model=TokenSchema)
async def Login(data: Annotated[OAuth2PasswordRequestForm, Depends()], db: Session = Depends(get_db)):
    user = authenticate_user(data.username, data.password, db)

    if not user:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail='Incorrect username or password',
            headers={"WWW-Authenticate": "Bearer"},
        )

    user = object_as_dict(user)
    
    access = create_access_token(user)
    refresh = create_refresh_token(user)

    return {
        'access_token': access,
        'refresh_token': refresh,
    }