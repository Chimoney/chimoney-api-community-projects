import BankDetails from "@/components/BankDetails";
import PaymentPointer from "@/components/PaymentPointer";
import Portfolio from "@/components/Portfolio";
import SocialMedia from "@/components/SocialMedia";
import ActivityFeed from "@/components/activityFeed";
import Bio from "@/components/bio";
import Contact from "@/components/contact";
import PayNow from "@/components/paynow";
import ProfessionalTitle from "@/components/professionalTitle";
import QRCode from "@/components/qrCode";
import user from "@/data/mockData";

export default function Home() {
  return (
    <main className={`bg-gradient-to-b from-[#670b7b] to-[#e6e6fa] min-h-screen flex flex-col justify-center items-center`}>
      <h2 className='text-center text-3xl text-[#e0e0e0] my-3 font-semibold'>USER PROFILE</h2>
      {user.upa.profile.verificationBadge && (
        <button className="px-4 py-1 mb-3 rounded-xl bg-green-400 text-white">Verified</button>
      )}
      <div className='bg-gradient-to-r from-[#ffffff] to-[#e0e0e0] mx-4 mb-4 max-w-sm md:max-w-[40rem] rounded-xl'>
        <div className="w-full p-3 overflow-y-auto">
          <PaymentPointer pointer={user.upa.payment.paymentPointer} />
          <BankDetails details={user.upa.payment.bankDetails} />
          <SocialMedia links={user.upa.profile.socialLinks} />
          <Portfolio link={user.upa.profile.portfolioLink} />
          <Bio bio={user.upa.profile.bio} />
          <ProfessionalTitle title={user.upa.profile.professionalTitle} />
          <ActivityFeed activities={user.upa.profile.activityFeed} />
          <div className="flex gap-4">
            <Contact receiverEmail={user.meta.email}/>
            <QRCode url={user.upa.payment.paymentPointer} />
          </div>
        </div>
        <PayNow />
      </div>
    </main>
  )
}