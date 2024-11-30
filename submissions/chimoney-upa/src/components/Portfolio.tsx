'use client'

import Link from "next/link";
import { AiOutlineEdit } from "react-icons/ai";
import Modal from "./ui/Modal";
import { useState } from "react";

export default function Portfolio({ link }: { link: string }){
  const [isModalOpen, setIsModalOpen] = useState(false);
  const updateLink = () => {
    // Function to update the Link
  }

  return (
    <section className="py-2 px-4 rounded-lg shadow-lg mt-4 bg-purple-100">
      <div className="flex gap-x-3 items-center justify-between">
        <h2 className="text-xl font-semibold">Portfolio</h2>
        <button onClick={() => setIsModalOpen(!isModalOpen)}>
          <AiOutlineEdit size={25} className='mx-3' />
        </button>
      </div>

      <Link href={link} target="_blank">{link}</Link>

      <Modal handleClose={() => setIsModalOpen(false)} isOpen={isModalOpen}>
        <h2 className="font-semibold text-xl mt-3">Portfolio Link</h2>
        <p className="mb-4">Add or Update Portfolio Link</p>
        <div className="flex flex-col md:flex-row gap-2">
          <input className="p-2 border-2 border-purple-500 rounded-s" type="url" defaultValue={link} />
          <button onClick={updateLink} className="bg-purple-500 text-white px-6 py-2.5 rounded-e">Go</button>
        </div>
      </Modal>
    </section>
  )
}