'use client';

import { useState } from "react";
import Modal from "./ui/Modal";

export default function Contact({ receiverEmail }: { receiverEmail: string}){
  const [isModalOpen, setIsModalOpen] = useState(false);
  const updateLink = () => {
    // Function to update the Link
  }
  
  return (
    <section className="px-4 py-2 flex items-center">
      <button className="px-6 py-2 bg-purple-400 hover:bg-purple-700 rounded-lg" onClick={()=> setIsModalOpen(!isModalOpen)}>Contact</button>

      <Modal isOpen={isModalOpen} handleClose={()=> setIsModalOpen(false)}>
        <form>
          <div>
            <label htmlFor="sendermail" className="block">Your email</label>
            <input id='sendermail' className="p-2 rounded-lg mb-2 border-2 border-purple-400" type="email" placeholder="Your Email" required />
          </div>
          <div>
            <label htmlFor="message" className="block">Message</label>
            <input id='message' className="p-2 rounded-lg mb-2 border-2 border-purple-400" type="text" placeholder="Your Message" required />
          </div>
          <div className="flex justify-center">
            <button className="px-6 py-2 bg-purple-600 text-white rounded-lg">Send </button>
          </div>
        </form>
      </Modal>
    </section>
  )
}