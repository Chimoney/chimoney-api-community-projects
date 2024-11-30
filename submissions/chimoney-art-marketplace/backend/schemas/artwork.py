import datetime

from pydantic import BaseModel
from typing import Optional, List


class ArtworkSchema(BaseModel):
    id: int
    title: str
    description: str
    image: str
    price: float
    # genre: List[str]
    style: str
    # artist_id: int
    # owner_id: int
    date_created: datetime.datetime
   
    class Config:
        from_attributes = True

class UpdateArtworkSchema(ArtworkSchema):
    title: Optional[str]
    description: Optional[str]
    image: Optional[str]
    price: Optional[float]
    genre: Optional[str]
    style: Optional[str]

    class Config:
        from_attributes = True