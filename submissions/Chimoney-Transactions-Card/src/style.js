import styled from "styled-components";

export const FormContainer = styled.main`
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 3rem;
  justify-content: center;
  box-sizing: border-box;
  margin-top: 4rem;

  h1 {
    text-align: center;
    margin-bottom: 1rem;
    font-size: 2.5rem;
  }

  form {
    padding: 1rem;
    margin: 2rem auto;
    width: 40vw;
    p {
      font-size: 1.2rem;
      margin-bottom: 0.3rem;
    }
    @media (max-width: 1050px) {
      width: 70vw;
    }

    .error-container {
      width: 90%;
      margin: 1rem;
      p {
        font-size: 1.2rem;
        text-decoration: wavy;
        text-transform: capitalize;
        padding: 1rem;
        text-align: center;
        font-weight: 600;
      }
    }
  }

  input,
  select {
    width: 98%;
    outline: none;
    font-size: 1.2rem;
    padding: 1rem;
    padding-right: 2rem;
    border: 1px solid #f8f8f8;
    background-color: #f8f8f8;
    margin-bottom: 2rem;
  }
  select{
    border-right: 16px solid transparent
  }

  input {
    width: 90%;
  }

  .button-container {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    @media (max-width: 1050px) {
      flex-direction: column;
    }
  }
  button {
    width: 220px;
    height: 60px;
    color: white;
    border: none;
    text-transform: uppercase;
    font-size: 1rem;
    transition: all ease-in 0.5secs;
    font-weight: 600;
    background: linear-gradient(
      253.27deg,
      #24022b 38.8%,
      rgba(166, 15, 193, 0.93) 84.32%
    );
    border-radius: 12px;
    :hover {
      cursor: pointer;
      font-size: 1.05rem;
    }
  }

  .sub-class {
    overflow-x: scroll;
  }
`;


export const CardWrapper = styled.section`
  display: flex;
    justify-content: space-evenly;
    align-items: center;
    margin-bottom: 10rem;

    .loading{
    display: block;
  text-align: center;
  img{
    width: 100px;
    height: 100px;
    border-radius: 50%;
  }
  }

.card-container{
  display: flex;
  justify-content: center;
  align-items: center;
  section {
    width: 428px;
    /* height: 970px; */
    /* margin: 5rem auto; */
    background: #f1f1f1;
    border-top-left-radius: 40px;
    border-top-right-radius: 40px;
  }
  .header {
    width: 428px;
    height: 351px;
    border-top-left-radius: 40px;
    border-top-right-radius: 40px;
    background-repeat: no-repeat;
    background-position-y: 50%;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;


    .card-circle {
      display: flex;
      margin-top: -59px;
      width: 151.37px;
      height: 151.37px;
      border-radius: 50%;
      background: linear-gradient(106.92deg, #fcfcff -3.29%, #ffffff 234.18%);
      filter: blur(5px);
    }

    .details {
      position: absolute;
      margin-top: -59px;

      h1 {
        font-weight: 600;
        font-size: 30px;
        line-height: 163.5%;
        color: #090707;
      }
      P {
        font-weight: 600;
        font-size: 14px;
        line-height: 161%;
        font-style: italic;
        text-align: center;
        color: #090707;
        text-shadow: 10px 10px 20px rgba(0, 0, 0, 0.25);
      }
      .usd {
        font-weight: 500;
        font-size: 10px;
        line-height: 161%;
        font-style: normal;
        text-shadow: 10px 10px 20px rgba(0, 0, 0, 0.25);
      }
    }

    img {
      position: absolute;
      z-index: 1;
      top: 35px;
      left: 120px;
    }
  }

  .footer {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin: 40px auto;

    .title {
      margin-top: -70px;
      margin-bottom: 40px;
      span {
        display: block;
        text-align: center;
      }
      h2 {
        font-style: italic;
        font-weight: 600;
        font-size: 18px;
        line-height: 27px;
        color: #090707;
      }
    }

    .block {
      margin-bottom: 10px;
    }

    .block {
      p {
        font-weight: 500;
        font-size: 12px;
        line-height: 18px;
        display: flex;
        align-items: center;
        text-align: center;
        color: #670b78;
      }
      .white-bg {
        padding: 10px;
        width: 265px;
        margin-top: 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #ffffff;
        border-radius: 12px;

        p {
          font-weight: 400;
          font-size: 14px;
          line-height: 21px;
          text-align: center;
          color: #090707;
        }
      }

      svg{
        margin-right: 9px;
      }

    }

    .redeem-gift {
      text-align: center;
      margin-top: 44px;
      h3 {
        font-weight: 600;
        margin-bottom: 16px;
        font-size: 14px;
        line-height: 21px;
      }
      .buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
        flex-wrap: wrap;
      }
      button + button{
        margin-left: 16px;
      }
      button {
        padding: 10px 13px 10px 24px;
        margin-bottom: 16px;
        gap: 10px;
        font-weight: 500;
        font-size: 12px;
        line-height: 18px;
        color: #fffff1;
        display: flex;
        align-items: center;
        text-align: center;
        height: 29px;
        background: linear-gradient(
          253.27deg,
          #400b4a 38.8%,
          rgba(166, 15, 193, 0.93) 84.32%
        );
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25),
          inset 8px -4px 4px rgba(38, 23, 41, 0.7);
        border-radius: 10px;
      }
    }
  }
}

`;

export const Special = styled.section`
display: flex;
justify-content: center;
align-items: center;
width: 220px;
padding: 10px;
border: 2px solid  rgba(166, 15, 193, 0.93);
height: 220px;
border-radius: 50%;
background: linear-gradient(106.92deg, #fcfcff -3.29%, #ffffff 234.18%);

h1{
  text-align: center;
  font-size: 1rem;
  font-weight: 400;
}
`;

