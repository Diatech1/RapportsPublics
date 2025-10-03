import { useEffect, useState } from 'react'
import { useParams, Link } from 'react-router-dom'
import { supabase } from '../lib/supabase'

export default function ReportDetail() {
  const { slug } = useParams()
  const [report, setReport] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    fetchReport()
  }, [slug])

  const fetchReport = async () => {
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
        .eq('slug', slug)
        .maybeSingle()

      if (error) throw error
      setReport(data)
    } catch (error) {
      console.error('Error fetching report:', error)
    } finally {
      setLoading(false)
    }
  }

  const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  }

  if (loading) {
    return (
      <main>
        <div className="container" style={{ padding: '5rem 1rem', textAlign: 'center' }}>
          <p>Chargement du rapport...</p>
        </div>
      </main>
    )
  }

  if (!report) {
    return (
      <main>
        <div className="container" style={{ padding: '5rem 1rem', textAlign: 'center' }}>
          <h1>Rapport non trouvé</h1>
          <p style={{ marginTop: '1rem' }}>Le rapport que vous recherchez n'existe pas.</p>
          <Link to="/rapports" className="btn" style={{ marginTop: '2rem' }}>
            Voir tous les rapports
          </Link>
        </div>
      </main>
    )
  }

  return (
    <main>
      <article style={{ padding: '3rem 0' }}>
        <div className="container" style={{ maxWidth: '900px' }}>
          <Link to="/rapports" style={{ color: 'var(--primary)', textDecoration: 'none', marginBottom: '2rem', display: 'inline-block' }}>
            <i className="fas fa-arrow-left"></i> Retour aux rapports
          </Link>

          {report.image_url && (
            <img
              src={report.image_url}
              alt={report.title}
              style={{
                width: '100%',
                height: '400px',
                objectFit: 'cover',
                borderRadius: '8px',
                marginBottom: '2rem'
              }}
            />
          )}

          <div style={{ marginBottom: '2rem' }}>
            {report.ministeres && (
              <span className="report-category">{report.ministeres.name}</span>
            )}
            {report.report_categories && (
              <span className="report-category" style={{ marginLeft: '0.5rem' }}>
                {report.report_categories.name}
              </span>
            )}
          </div>

          <h1 style={{ fontSize: '2.5rem', marginBottom: '1rem', color: 'var(--primary)' }}>
            {report.title}
          </h1>

          <div style={{ color: 'var(--gray)', marginBottom: '2rem', display: 'flex', gap: '2rem', flexWrap: 'wrap' }}>
            <span>
              <i className="far fa-calendar"></i> Publié le {formatDate(report.publication_date)}
            </span>
            {report.file_size && (
              <span>
                <i className="far fa-file-pdf"></i> {report.file_size}
              </span>
            )}
            <span>
              <i className="fas fa-download"></i> {report.download_count} téléchargements
            </span>
          </div>

          <div style={{ fontSize: '1.1rem', lineHeight: '1.8', marginBottom: '3rem' }}>
            <p style={{ fontSize: '1.2rem', color: 'var(--dark)', fontWeight: '500', marginBottom: '1rem' }}>
              {report.excerpt}
            </p>
            <p style={{ whiteSpace: 'pre-line' }}>{report.content}</p>
          </div>

          {report.file_url && (
            <div style={{ textAlign: 'center', padding: '2rem', background: 'var(--light)', borderRadius: '8px' }}>
              <a href={report.file_url} className="btn" download>
                <i className="fas fa-download"></i> Télécharger le rapport PDF
              </a>
            </div>
          )}
        </div>
      </article>
    </main>
  )
}
