import datetime
from pydantic import BaseModel, EmailStr
from typing import List, Optional


class UserSchema(BaseModel):
    first_name: str
    last_name: str
    username: str
    email: EmailStr
    password: str
    bio: str
    is_artist: bool
    artworks: List[str]

    class Config:
        from_attributes = True


class UpdateUserSchema(UserSchema):
    first_name: Optional[str]
    last_name: Optional[str]
    username: Optional[str]
    email: Optional[EmailStr]
    password: Optional[str]
    bio: Optional[str]
    is_artist: Optional[bool]


class UserLoginSchema(BaseModel):
    username: str
    password: str


class TokenSchema(BaseModel):
    access_token: str
    refresh_token: str


class TokenCreate(BaseModel):
    user_id:str
    access_token:str
    refresh_token:str
    status:bool
    created_date:datetime.datetime