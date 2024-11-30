import { toast } from 'sonner'

type ToastProps = {
  type: 'success' | 'error',
  message: string
}

export default function notify({ type, message}: ToastProps){
  type === 'success' ? toast.success(message) : toast.error(message)
}