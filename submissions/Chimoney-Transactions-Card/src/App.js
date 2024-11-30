import React from 'react';
import './App.css';
import {
  BrowserRouter as Router, 
  Routes, 
  Route
} from 'react-router-dom';
import {ComingSoon, Transactions}from './Transaction';
import {TransactionCard} from './Transaction';

function App() {
  return (
    <div className="App">
      <Router>
        <Routes>
          <Route path='/' element={<Transactions/>} exact >
            <Route path='/giftID=:id&platform=:platform' element={<TransactionCard/>} />
            <Route path='/coming-soon' element={<ComingSoon/>} />
          </Route>
        </Routes>
      </Router>
    </div>
  );
}

export default App;
