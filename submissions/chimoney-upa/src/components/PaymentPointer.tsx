'use client';

import {AiOutlineCopy} from 'react-icons/ai'
import notify from './Toast';


export default function PaymentPointer({ pointer }: { pointer: string }){
  const copyPaymentPointer = () => {
    navigator.clipboard.writeText(pointer)
    notify({type:'success', message:'Copied to Clipboard'})
  };

  return (
    <section className="p-2 border-b border-purple-800 shadow-lg">
      <h2 className="text-xl font-semibold mb-3">Payment Pointer</h2>
      <div className="flex items-center">
        <input type="text" value={pointer} readOnly className="flex-1 p-2 rounded-l border-purple-600 bg-purple-100 text-purple-800"/>
        <button onClick={copyPaymentPointer} className='bg-purple-600 text-white p-3 rounded-r'><AiOutlineCopy /></button>
      </div>
    </section>
  )
}