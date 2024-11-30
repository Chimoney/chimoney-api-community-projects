import { socialLinks } from "@/types/user";
import Link from "next/link";
import { RiTwitterXFill } from 'react-icons/ri';
import { BiLogoLinkedin } from 'react-icons/bi';
import { AiOutlineGithub } from 'react-icons/ai';

export default function SocialMedia({ links }: { links: socialLinks }) {
  return (
    <section className="px-4 py-2 rounded-lg shadow-lg mt-4 bg-purple-100">
      <h2 className="text-xl font-semibold">Social Links</h2>
      <div className="flex justify-center gap-x-4">
        { links.twitter && (
          <Link target='_blank' href={links.twitter} className="p-3">
            <RiTwitterXFill size={20} />
          </Link>
        )}
        { links.linkedin && (
          <Link target='_blank' href={links.linkedin} className="p-3">
            <BiLogoLinkedin size={20} />
          </Link>
        )}
        { links.github && (
          <Link target='_blank' href={links.github} className="p-3">
            <AiOutlineGithub size={20} />
          </Link>
        )}
      </div>
    </section>
  )
}