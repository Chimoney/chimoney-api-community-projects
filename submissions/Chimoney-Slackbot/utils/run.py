#! /usr/bin/env python
from app import app

if __name__ == "__main__":
    # Only use app.run() in development, not in production
    app.run(debug=True, host="0.0.0.0", port=5050)

