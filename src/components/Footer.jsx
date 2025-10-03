export default function Footer() {
  return (
    <footer>
      <div className="container">
        <div className="footer-container">
          <div className="footer-about">
            <div className="footer-logo">
              <i className="fas fa-file-alt"></i>
              Rapports Publics
            </div>
            <p>
              Plateforme officielle de consultation des rapports publics de la République du Sénégal.
              Promouvoir la transparence et l'accès à l'information gouvernementale.
            </p>
            <div className="social-links">
              <a href="#" aria-label="Facebook"><i className="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="Twitter"><i className="fab fa-twitter"></i></a>
              <a href="#" aria-label="LinkedIn"><i className="fab fa-linkedin-in"></i></a>
            </div>
          </div>

          <div className="footer-links">
            <h3>Liens Rapides</h3>
            <ul>
              <li><a href="/">Accueil</a></li>
              <li><a href="/rapports">Tous les rapports</a></li>
              <li><a href="#about">À propos</a></li>
              <li><a href="#faq">FAQ</a></li>
            </ul>
          </div>

          <div className="footer-links">
            <h3>Ministères</h3>
            <ul>
              <li><a href="#">Santé</a></li>
              <li><a href="#">Éducation</a></li>
              <li><a href="#">Finances</a></li>
              <li><a href="#">Intérieur</a></li>
            </ul>
          </div>

          <div className="footer-links">
            <h3>Contact</h3>
            <ul>
              <li><a href="mailto:contact@rapports.sn">contact@rapports.sn</a></li>
              <li><a href="tel:+221338234567">+221 33 823 45 67</a></li>
              <li>Dakar, Sénégal</li>
            </ul>
          </div>
        </div>

        <div className="copyright">
          <p>&copy; 2024 République du Sénégal - Tous droits réservés</p>
        </div>
      </div>
    </footer>
  )
}
