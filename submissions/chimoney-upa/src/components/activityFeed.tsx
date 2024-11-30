import { activityFeed } from "@/types/user";

export default function ActivityFeed({ activities }: { activities: activityFeed[] }){
  return (
    <section className="p-4 rounded-lg shadow-lg mt-4 bg-purple-100">
      <h2 className="text-xl font-semibold">{`${activities.length > 1 ? 'Activities' : 'Activity'} `}</h2>
      {activities?.map((activity, idx) => (
        <div key={idx}>
          <h2 className="capitalize">{activity.type}</h2>
          <p>{activity.description}</p>
          <p className="text-gray-800 text-sm">{activity.date}</p>

          {activities.length - 1 !== idx && <hr className="border bg-purple-200" />}
        </div>
      ))}      
    </section>
  )
}