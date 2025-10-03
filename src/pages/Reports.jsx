import { useEffect, useState } from 'react'
import { supabase } from '../lib/supabase'
import ReportCard from '../components/ReportCard'

export default function Reports() {
  const [reports, setReports] = useState([])
  const [ministeres, setMinisteres] = useState([])
  const [categories, setCategories] = useState([])
  const [loading, setLoading] = useState(true)
  const [selectedMinistere, setSelectedMinistere] = useState('')
  const [selectedCategory, setSelectedCategory] = useState('')

  useEffect(() => {
    fetchData()
  }, [])

  useEffect(() => {
    fetchReports()
  }, [selectedMinistere, selectedCategory])

  const fetchData = async () => {
    try {
      const [ministeresRes, categoriesRes] = await Promise.all([
        supabase.from('ministeres').select('*').order('name'),
        supabase.from('report_categories').select('*').order('name')
      ])

      setMinisteres(ministeresRes.data || [])
      setCategories(categoriesRes.data || [])
    } catch (error) {
      console.error('Error fetching data:', error)
    }
  }

  const fetchReports = async () => {
    setLoading(true)
    try {
      let query = supabase
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

      if (selectedMinistere) {
        query = query.eq('ministere_id', selectedMinistere)
      }
      if (selectedCategory) {
        query = query.eq('category_id', selectedCategory)
      }

      const { data, error } = await query

      if (error) throw error
      setReports(data || [])
    } catch (error) {
      console.error('Error fetching reports:', error)
    } finally {
      setLoading(false)
    }
  }

  return (
    <main>
      <section style={{ paddingTop: '3rem' }}>
        <div className="container">
          <h1 className="section-title">Tous les Rapports</h1>

          <div style={{ marginBottom: '2rem', display: 'flex', gap: '1rem', flexWrap: 'wrap', justifyContent: 'center' }}>
            <select
              value={selectedMinistere}
              onChange={(e) => setSelectedMinistere(e.target.value)}
              style={{
                padding: '0.5rem 1rem',
                borderRadius: '8px',
                border: '1px solid #8d99ae',
                fontSize: '1rem'
              }}
            >
              <option value="">Tous les ministères</option>
              {ministeres.map((ministere) => (
                <option key={ministere.id} value={ministere.id}>
                  {ministere.name}
                </option>
              ))}
            </select>

            <select
              value={selectedCategory}
              onChange={(e) => setSelectedCategory(e.target.value)}
              style={{
                padding: '0.5rem 1rem',
                borderRadius: '8px',
                border: '1px solid #8d99ae',
                fontSize: '1rem'
              }}
            >
              <option value="">Toutes les catégories</option>
              {categories.map((category) => (
                <option key={category.id} value={category.id}>
                  {category.name}
                </option>
              ))}
            </select>
          </div>

          {loading ? (
            <p style={{ textAlign: 'center' }}>Chargement des rapports...</p>
          ) : reports.length === 0 ? (
            <p style={{ textAlign: 'center' }}>Aucun rapport trouvé.</p>
          ) : (
            <div className="reports-grid">
              {reports.map((report) => (
                <ReportCard key={report.id} report={report} />
              ))}
            </div>
          )}
        </div>
      </section>
    </main>
  )
}
