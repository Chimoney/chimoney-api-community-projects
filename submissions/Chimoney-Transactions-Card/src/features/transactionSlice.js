import { createSlice } from "@reduxjs/toolkit";
import axios from "axios";


export const transactionSlice = createSlice({
  name: "transaction",

  initialState: {
    data: [],
    another: "",
  },

  reducers: {

    getTransaction: (state, action) => {
      state.data = action.payload;
    },

  },
});

export const getTransactionAsync = (issueID) => {

 const API_KEY = process.env.REACT_APP_CHICONNECT_KEY;

  return function (dispatch) {
    const config = {
        method: 'POST',
        url: `https://api.chimoney.io/v0.2/accounts/issue-id-transactions?issueID=${issueID}`,
        headers: { 
          'X-API-Key': API_KEY
        },
      };
      
      axios(config)
      .then(function (response) {
        let data = (response.data).data;
        console.log(data)
        dispatch(getTransaction(data));
      })
      .catch(function (error) {
          console.log(error);
      });

  };
};


export const {getTransaction, getError} =
  transactionSlice.actions;
export default transactionSlice.reducer;
