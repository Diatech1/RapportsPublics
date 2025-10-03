import { useState } from 'react'
import { Link } from 'react-router-dom'

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false)

  return (
    <header>
      <div className="container">
        <div className="header-container">
          <Link to="/" className="logo">
            <i className="fas fa-file-alt"></i>
            <span>Rapports Publics</span>
          </Link>

          <button
            className="menu-toggle"
            onClick={() => setMenuOpen(!menuOpen)}
            aria-label="Toggle menu"
          >
            <i className={`fas ${menuOpen ? 'fa-times' : 'fa-bars'}`}></i>
          </button>

          <nav>
            <ul className={menuOpen ? 'show' : ''}>
              <li><Link to="/" onClick={() => setMenuOpen(false)}>Accueil</Link></li>
              <li><Link to="/rapports" onClick={() => setMenuOpen(false)}>Rapports</Link></li>
              <li><a href="#about" onClick={() => setMenuOpen(false)}>À propos</a></li>
              <li><a href="#faq" onClick={() => setMenuOpen(false)}>FAQ</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>
  )
}
