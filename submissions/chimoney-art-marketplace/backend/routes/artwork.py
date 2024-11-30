from typing import Annotated
from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from database.crud import get_artworks, get_artwork_by_id, create_artwork
from database.database import get_db

from schemas.artwork import ArtworkSchema

from models.user import User
from models.artwork import Artwork

from services.auth import get_current_user

from responses.response import ResponseClass

router = APIRouter(prefix='/api', tags=['Artwork'])


@router.get('/')
async def get_art(db: Session = Depends(get_db)):
    return get_artworks(db=db)

@router.post('/', response_model=ResponseClass, status_code=201)
async def create_art(data: ArtworkSchema, db: Session = Depends(get_db), artist: User = Depends(get_current_user)):
    print(data)
    # data = dict(data)
    # new_artwork = Artwork(
    #     **data,
    #     artist_id = artist['id'],
    # )
    art = create_artwork(db, data, artist['id'])
    
    return ResponseClass(
        message='Artwork created successfully',
        statusCode=201,
        data=dict(art)
    )

@router.get('/art/{art_id}')
async def get_art_by_id(art_id: int, db: Session = Depends(get_db)):
    artwork = get_artwork_by_id(artwork_id=art_id, db=db)

    return artwork
