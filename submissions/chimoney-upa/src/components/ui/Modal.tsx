import { ReactNode, useEffect } from "react";
import ReactPortal from "./Portal";
import { FaTimes } from "react-icons/fa";

interface ModalProps {
  isOpen: boolean;
  handleClose: () => void
  children: ReactNode
}

export default function Modal({ children, isOpen, handleClose }: ModalProps){
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
            {children}
          </div>
        </div>
      </div>
    </ReactPortal>
  )
}