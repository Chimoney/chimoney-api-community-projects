# PayPaddy

React web app that utilizes most of Chiconnect api endpoints to enable a variety of payouts such including Bank, Airtime, Mobile Money, Giftcards payouts and more.

## Setup

- `git clone <project_url>`
- `cd chimoney-api-community-projects/submissions/pay-paddy`
- `npm install`
- create a file in root directory with `.env` as the name and add the API key in this format `API_KEY='api key'`
- `npm run dev`

## Deps

- [React](https://reactjs.org/)
  - Frontend web framework for building Single Page Applications (SPA)
- [React-router-dom](https://reactrouter.com/en/main/start/overview)
  - Enables client side routing for React web applications
- [Redux](https://redux.js.org/)
  - Javascript library for managing and centralizing state
- [Reduxjs/toolkit](https://redux.js.org/redux-toolkit/overview)
  - Toolkit which simplifies writing Redux use cases
- [Redux thunk](https://github.com/reduxjs/redux-thunk)
  - It allows writing functions with logic inside that can interact with a Redux store's dispatch and getState methods
- [Redux firestore](https://www.npmjs.com/package/redux-firestore)
  - Redux bindings for firestore
- [React redux firebase](https://www.npmjs.com/package/redux-firestore)
  - Provides Redux bindings for Firebase
- [Phosphor react icons](https://phosphoricons.com/)
  - Flexible icon family for interfaces, diagrams, presentations

## Commit style guidelines

A commit message should easily convey what it contains so the guidelines show a commit should be for this project.

The commit message should be in this format `type: subject` where `type` can be any one of these:

- `feat: a new feature`
- `fix: a bug fix`
- `docs: changes to documentation`
- `style: formatting, missing semi colons, etc; no code change`
- `refactor: refactoring production code`
- `test: adding tests, refactoring test; no production code change`
- `chore: updating build tasks, package manager configs, etc; no production code change`

and the `subject` should be no greater than 50 characters, should begin with an uppercase and should use imperative tone. E.g: 'change'; not 'changed' or 'changes'
