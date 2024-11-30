import { useEffect, useState } from "react";
import ReactPortal from "./Portal";
import { FaTimes } from "react-icons/fa";

interface ModalProps {
  isOpen: boolean;
  handleClose: () => void
  handlePasswordVerification: (isCorrect: boolean) => void; // Pass the callback function
}

export default function PasswordModal({ isOpen, handleClose, handlePasswordVerification }: ModalProps){
  const [password, setPassword] = useState('');

  const handlePasswordSubmit = () => password === 'yourPassword' ? handlePasswordVerification(true) : handlePasswordVerification(false)

  useEffect(() => {
    const closeOnEscapeKey = (e: KeyboardEvent) => e.key === 'Escape' ? handleClose() : null;
    document.body.addEventListener('keydown', closeOnEscapeKey)
    return () => {
      document.body.removeEventListener('keydown', closeOnEscapeKey) 
    };
  }, [handleClose])

  if (!isOpen) return null

  return (
    <ReactPortal wrapperId="modal-container">
      <div className="fixed inset-0 z-40 backdrop-blur-2xl bg-opacity-50">
        <div className="fixed rounded-3xl top-1/2 left-1/2 max-h-full p-6 sm:max-w-sm md:max-w-[40rem] -translate-x-1/2 -translate-y-1/2 flex flex-col bg-white justify-center items-center">
          <button onClick={handleClose}><FaTimes size={32}/></button>
          <div className="w-full overflow-auto flex-grow p-2">
            <h2 className="text-xl font-semibold">Enter Password</h2>
            <input
              type="password"
              placeholder="Enter password"
              value={password}
              onChange={(e)=>setPassword(e.target.value)}
              className="p-2 my-2 md:my-4 border-2 border-purple-600 rounded-lg" 
            />
            <button onClick={handlePasswordSubmit} className="px-6 py-2 md:py-3 bg-[#670b7b] text-[#e0e0e0] rounded-xl">Go</button>
          </div>
        </div>
      </div>
    </ReactPortal>
  )
}