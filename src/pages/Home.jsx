import { useEffect, useState } from 'react'
import { supabase } from '../lib/supabase'
import Hero from '../components/Hero'
import About from '../components/About'
import FAQ from '../components/FAQ'
import ReportCard from '../components/ReportCard'

export default function Home() {
  const [reports, setReports] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    fetchReports()
  }, [])

  const fetchReports = async () => {
    try {
      const { data, error } = await supabase
        .from('reports')
        .select(`
          *,
          ministeres (
            id,
            name,
            slug
          ),
          report_categories (
            id,
            name,
            slug
          )
        `)
        .order('publication_date', { ascending: false })
        .limit(8)

      if (error) throw error
      setReports(data || [])
    } catch (error) {
      console.error('Error fetching reports:', error)
    } finally {
      setLoading(false)
    }
  }

  return (
    <>
      <Hero />
      <About />

      <section id="reports">
        <div className="container">
          <h2 className="section-title">Rapports Récents</h2>
          {loading ? (
            <p style={{ textAlign: 'center' }}>Chargement des rapports...</p>
          ) : (
            <div className="reports-grid">
              {reports.map((report) => (
                <ReportCard key={report.id} report={report} />
              ))}
            </div>
          )}
        </div>
      </section>

      <FAQ />
    </>
  )
}
