import { QRCodeSVG } from "qrcode.react"

export default function QRCode({ url }: {url: string}){
  return (
    <section className="px-4 py-2 flex items-center justify-center">
      <QRCodeSVG value={url} />
    </section>
  )
}