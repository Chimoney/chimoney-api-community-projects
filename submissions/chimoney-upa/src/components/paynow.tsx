'use client';

import { useState } from "react";
import Modal from "./ui/Modal";

export default function PayNow(){
  const [isModalOpen, setIsModalOpen] = useState(false);
   
  return (
    <div className="flex justify-center items-center mb-2">
      <button onClick={() => setIsModalOpen(!isModalOpen)} className="bg-[#670b7b] rounded-lg text-white py-2 px-6">Pay Now</button>

      <Modal isOpen={isModalOpen} handleClose={() => setIsModalOpen(false)}>
        <form>
          <div>
            <label htmlFor="sendermail" className="block">Your email</label>
            <input id='sendermail' className="p-2 rounded-lg mb-2 border-2 border-purple-400" type="email" placeholder="Your Email" required />
          </div>
          <div>
            <label htmlFor="amount" className="block">Amount</label>
            <input id='amount' className="p-2 rounded-lg mb-2 border-2 border-purple-400" type="number" placeholder="Amount" required />
          </div>
          <div className="flex justify-center">
            <button className="px-6 py-2 bg-purple-600 text-white rounded-lg">Pay </button>
          </div>
        </form>
      </Modal>
    </div>
  )
}