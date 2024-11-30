from typing import Optional, Annotated
from pydantic import BaseModel
from fastapi import status, HTTPException

from schemas.artwork import ArtworkSchema, UpdateArtworkSchema
from schemas.user import UserSchema, UpdateUserSchema


class Response:
    message: str
    statusCode: int
    data: dict


class ResponseClass(BaseModel):
    message: str = None
    statusCode: int = None
    data: Optional[dict] = None


class UserResponse(ResponseClass):
    data: UserSchema


class UpdateUserResponse(ResponseClass):
    data: UpdateUserSchema


class ArtworkResponse(ResponseClass):
    data: ArtworkSchema


class UpdateArtworkResponse(ResponseClass):
    data: UpdateArtworkSchema