import React, { useState } from "react";
import { Outlet, useNavigate, useParams } from "react-router-dom";
import { Twitter, Mail, Check, Cancel } from "./assets/icons";
import Gift from "./assets/gift.png";
import { FormContainer, CardWrapper, Special } from "./style.js";
import BG from "./assets/bg.png"
import { getTransactionAsync } from "./features/transactionSlice";
import { useDispatch, useSelector } from "react-redux";
import { useEffect } from "react";
import Loading from "./assets/spin.gif";

export const Transactions = () => {
  const [platform, setPlatform] = useState("");
  const [issueID, setIssueID] = useState("");
  const [ErrorMsg, setErrorMsg] = useState("");

  const navigate = useNavigate();
  const dispatch = useDispatch();
  
  const handleChange = (e) => {
    const { name, value } = e.currentTarget;
    if (name === "issueID") {
      setIssueID(value);
    } else {
      setPlatform(value);
    }
    console.log(issueID);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!issueID || !platform) {
      setErrorMsg("please input all details");
    } else if(platform === "tremendous"){
      navigate('/coming-soon');
    }else {
      dispatch(getTransactionAsync(issueID));
      navigate(`/giftID=${issueID}&platform=${platform}`);
    }
  };

  const clearErrorMsg = () => {
    setErrorMsg("");
  };

  return (
    <>
    <FormContainer onMouseDown={clearErrorMsg} onKeyDown={clearErrorMsg}>
      <h1>Chimoney Transaction</h1>
      {ErrorMsg ? (
        <div className="error-container">
          <p>{ErrorMsg}</p>
        </div>
      ) : (
        ""
      )}
      <form>
        <div>
          <p>Enter Issue ID </p>
          <input
            type="text"
            name="issueID"
            onChange={handleChange}
            placeholder="b4393b87******"
          />
        </div>

        <div>
          <p>Transaction Platform</p>
          <select name="platform" id="platform" onChange={handleChange}>
            <option value="">Select Your Platform</option>
            <option value="chimoney">Chimoney</option>
            <option value="tremendous">Tremendous</option>
          </select>
        </div>

        <div className="button-container">
          <button type="submit" onClick={handleSubmit}>
            Submit
          </button>
        </div>
      </form>
    </FormContainer>
      <Outlet/>
    </>
  );
};

export const TransactionCard = () => {

  const dispatch = useDispatch();
  const { id } = useParams();

  const data = useSelector((state) => state.transaction.data);
  
  useEffect(() => {
    if(id){
      dispatch(getTransactionAsync(id));
    }
    console.log(data);
    }, [])

  return (
    <CardWrapper>
      {data.error ?  
        <Special>
          <h1> The Transaction you are looking for does not exist.. </h1>
        </Special> 
        : 
        data.length !== 0 ? 
        data.map((item)=>(
          <div className="card-container">
            <section>
              <div className="header" style={{backgroundImage:`url(${BG})`}} >
                <img src={Gift} alt="gift-box" />
                <div className="card-circle"></div>
                <div className="details">
                  <p>Chi money</p>
                  <h1>{item.chimoney}</h1>
                  <p className="usd">({item.valueInUSD} USB)</p>
                </div> 
              </div>
              <div className="footer">
                {item.twitter ? 
              <div className="title">
                <span>{Twitter}</span>
                <h2>{item.twitter}</h2>
                </div>
                : 
                <div className="title">
                <span>{Mail}</span>
                <h2>{item.email}</h2>
                </div> 
              }
              {item.twitter ? 
                <div class="block">
                  <p>Email address</p>
                  <div className="white-bg">
                    <p>{item.email}</p>
                  </div>
                </div>
                : ""}
                <div class="block">
                  <p>Status</p>
                  <div className="white-bg">
                    {item.status === "paid" ? 
                    <p>{Check} {item.status}</p>
                    :
                    <p>{Cancel} {item.status}</p>
                    }
                  </div>
                </div>
                <div class="block">
                  <p>Chi-ref</p>
                  <div className="white-bg">
                    <p>{item.chiRef.slice(0,25)}...</p>
                  </div>
                </div>
                <div class="block">
                  <p>Issue ID</p>
                  <div className="white-bg">
                    <p>{item.issueID.slice(0,25)}...</p>
                  </div>
                </div>
                <div class="block">
                  <p>Issued Date</p>
                  <div className="white-bg">
                    <p>{item.issueDate.slice(0,10)}</p>
                  </div>
                </div>

                <div className="redeem-gift">
                  <h3>Can redeem gift as</h3>

              <div className="buttons">
                  {item.enabledToRedeem.map((item) =>(
                    (item ===  
                      "Mobile and Internet" ?  
                      <button>Data</button> : 
                      <button>{item}</button>
                  )))}
              </div>
                </div>
              </div>
            </section>
          </div>
        )) 
        : data.length === 0 ?
        <div  className="loading">
           <img src={Loading} alt="loading"/>
        </div> 
    : "" }
    </CardWrapper>
  );
};

export const ComingSoon = () => {
  return (
    <CardWrapper>
      <Special>
        <h1>Coming soon... </h1>
      </Special>
    </CardWrapper>
  )
}