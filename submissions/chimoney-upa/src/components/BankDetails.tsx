'use client';

import { bankDetails } from "@/types/user";
import { useState } from "react";
import { AiOutlineEye, AiOutlineEyeInvisible } from "react-icons/ai";
import notify from "./Toast";
import PasswordModal from "./ui/PasswordModal";


export default function BankDetails({ details }: { details: bankDetails}){
  const [showDetails, setShowDetails] = useState(false);
  const [isPasswordModalOpen, setIsPasswordModalOpen] = useState(false)

  const handleDetailsToggle = () => showDetails ? setShowDetails(!showDetails) : setIsPasswordModalOpen(true)
  
  const formatLabel = (label: string): string => {
    // Replace camelCase with space-separated words
    return label.replace(/([A-Z])/g, ' $1').trim();
  }

  const closePasswordModal = () => setIsPasswordModalOpen(false);

  const handlePasswordVerification = (isCorrect: boolean) => {
    if (isCorrect) {
      notify({ type:'success', message:'Password is correct. You can now display bank details.' });
      setShowDetails(true)
      setIsPasswordModalOpen(false); // Close the modal after successful password verification
    } else notify({ type:'error', message:'Incorrect password. Please try again.' });
  };

  return (
    <section className="px-4 py-2 rounded-lg shadow-lg mt-4 bg-purple-100">
      <div className="flex items-center justify-between">
        <h2 className="text-xl font-semibold">Bank Details</h2>
        <div>
          {showDetails ? <button onClick={handleDetailsToggle} className="mx-4 p-1"><AiOutlineEye size={25} /></button> : <button className='mx-4 p-1' onClick={handleDetailsToggle}><AiOutlineEyeInvisible size={25} /></button> }
        </div>
      </div>

      <PasswordModal isOpen={isPasswordModalOpen} handleClose={closePasswordModal} handlePasswordVerification={handlePasswordVerification} />
        
      {showDetails && (
        <div className="grid grid-cols-2 gap-2 md:gap-x-8 mt-2">
          {Object.entries(details).map(([label, value]) => (
            <div key={label}>
              <label className="text-gray-600 uppercase font-medium break-words">{formatLabel(label)}</label>
              <p className="text-gray-800 text-sm break-words">{value}</p>
            </div>
          ))}
        </div>
      )}

    </section>
  )
}
