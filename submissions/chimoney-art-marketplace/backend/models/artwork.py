from sqlalchemy import Boolean, Column, ForeignKey, Integer, String, DateTime, Float, Identity
from sqlalchemy.orm import relationship

from schemas.artwork import ArtworkSchema

from database.database import Base


class Artwork(Base):
    __tablename__ = 'artworks'

    id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    title = Column(String, index=True)
    description = Column(String, index=True)
    # genre = Column(String, index=True)
    style = Column(String, index=True)
    artist_id = Column(Integer, ForeignKey('users.id'))
    # owner_id = Column(Integer, ForeignKey('users.id'))
    price = Column(Float)
    image = Column(String)
    date_created = Column(DateTime, index=True)

    owner = relationship('User', back_populates='artworks')