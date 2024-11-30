from fastapi import Depends, HTTPException, status

from sqlalchemy.orm import Session

from database.database import get_db

from models.artwork import Artwork
from models.user import User

from schemas.artwork import ArtworkSchema, UpdateArtworkSchema
from schemas.user import UserSchema


################### USER ###################

def get_user(db: Session, username: str):
    return db.query(User).filter(User.username == username).first()

def get_user_by_email(db: Session, email: str):
    return db.query(User).filter(User.email == email).first()

def get_users(db: Session, skip: int = 0, limit: int = 100):
    return db.query(User).offset(skip).limit(limit).all()

# def create_user(db: Session, user: UserSchema):
#     fake_hashed_password = user.password + "notreallyhashed"
#     db_user = User(
#         first_name = user.first_name,
#         last_name = user.last_name,
#         email=user.email,
#         username = user.username,
#         hashed_password=fake_hashed_password
#         )
#     db.add(db_user)
#     db.commit()
#     db.refresh(db_user)
#     return db_user


################### ARTWORKS ################### 

def get_artworks(db: Session, skip: int = 0, limit: int = 100):
    return db.query(Artwork).offset(skip).limit(limit).all()

def get_artwork_by_id(db: Session, artwork_id: int):
    return db.query(Artwork).filter(Artwork.id == artwork_id).first()

def get_artwork_by_genre(db: Session, genre: str):
    pass

def get_artwork_by_style(db: Session, style: str):
    return db.query(Artwork).filter(Artwork.style == style).all()

def create_artwork(db: Session, artwork: ArtworkSchema, user_id: int):
    db_artwork = Artwork(
        **artwork.model_dump(),
        artist_id = user_id,
    )

    # Check if artwork exists
    db_check = db.query(Artwork).filter(Artwork.title == artwork.title).all()

    if len(db_check) > 0:
        raise HTTPException(
            status_code=status.HTTP_409_CONFLICT,
            detail='Artwork already exists'
        )
    
    db.add(db_artwork)
    db.commit()
    db.refresh(db_artwork)
    return db_artwork