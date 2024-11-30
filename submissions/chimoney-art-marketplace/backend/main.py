from fastapi import FastAPI, status
from fastapi.middleware.cors import CORSMiddleware

from routes import artwork, auth

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=['*'],    # Add an actual URl so that auth would be possible
    allow_credentials=True,
    allow_methods=['*'],
    allow_headers=['*'],
)

app.include_router(artwork.router)
app.include_router(auth.router)