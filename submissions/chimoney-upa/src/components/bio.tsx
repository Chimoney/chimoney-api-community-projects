'use client';

import { useState } from "react";
import { AiOutlineEdit } from "react-icons/ai";
import Modal from "./ui/Modal";

export default function Bio({ bio }: { bio: string}){
  const [isModalOpen, setIsModalOpen] = useState(false);
  const closeModal = () => setIsModalOpen(false);
  const updateLink = () => {
    // Function to update the Link
  }
  
  return (
    <section className="px-4 py-2 rounded-lg shadow-lg mt-4 bg-purple-100">
      <div className="flex gap-x-3 items-center justify-between">
        <h2 className="text-xl font-semibold">Bio</h2>
        <button onClick={() => setIsModalOpen(!isModalOpen)}>
          <AiOutlineEdit size={25} className='mx-3' />
        </button>
      </div>
      <p className="mt-4 text-gray-600 break-words">{bio}</p>

      <Modal handleClose={closeModal} isOpen={isModalOpen}>
        <h2 className="font-semibold text-xl mt-3">Bio</h2>
        <p className="mb-4">Add or Update Bio</p>
        <div className="flex flex-col md:flex-row gap-2">
          <input className="p-2 border-2 border-purple-500 rounded-s" type="text" defaultValue={bio} />
          <button onClick={updateLink} className="bg-purple-500 text-white px-6 py-2.5 rounded-e">Go</button>
        </div>
      </Modal>
      
    </section>
  )
}