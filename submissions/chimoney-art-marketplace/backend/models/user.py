import datetime

from sqlalchemy import Column, Boolean, Integer, ForeignKey, String, DateTime
from sqlalchemy.orm import relationship

from schemas.user import UserSchema

from database.database import Base


class User(Base):
    __tablename__ = 'users'

    id = Column(Integer, primary_key=True, index=True, autoincrement=True)
    first_name = Column(String)
    last_name = Column(String)
    email = Column(String, unique=True, index=True)
    username = Column(String, unique=True, index=True)
    hashed_password = Column(String)
    bio = Column(String)
    is_active = Column(Boolean, default=False)
    is_artist = Column(Boolean, default=False)

    artworks = relationship('Artwork', back_populates='owner')

    def full_name(self):
        return f'{self.first_name} {self.last_name}'
    

class TokenTable(Base):
    __tablename__ = 'token'

    user_id = Column(Integer)
    access_toke = Column(String(450), primary_key=True)
    refresh_toke = Column(String(450), nullable=False)
    status = Column(Boolean)
    created_date = Column(DateTime, default=datetime.datetime.now)