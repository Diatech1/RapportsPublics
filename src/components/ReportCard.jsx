import { Link } from 'react-router-dom'

export default function ReportCard({ report }) {
  const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  }

  return (
    <article className="report-card">
      {report.image_url && (
        <img src={report.image_url} alt={report.title} loading="lazy" />
      )}
      <div className="report-content">
        {report.ministeres && (
          <span className="report-category">{report.ministeres.name}</span>
        )}
        <h3 className="report-title">
          <Link to={`/rapport/${report.slug}`}>{report.title}</Link>
        </h3>
        <p className="report-excerpt">{report.excerpt}</p>
        <div className="report-meta">
          <span className="report-date">
            Publié le {formatDate(report.publication_date)}
          </span>
        </div>
      </div>
    </article>
  )
}
