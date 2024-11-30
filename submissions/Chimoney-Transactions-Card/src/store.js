import { configureStore } from '@reduxjs/toolkit';
import transactionSlice from './features/transactionSlice';

export default configureStore({
  reducer: {
    transaction: transactionSlice,
  },
});