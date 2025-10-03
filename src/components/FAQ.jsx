import { useState } from 'react'

const faqData = [
  {
    question: "Comment puis-je accéder aux rapports ?",
    answer: "Tous les rapports sont accessibles gratuitement sur cette plateforme. Vous pouvez naviguer par ministère, catégorie ou utiliser la fonction de recherche pour trouver un rapport spécifique."
  },
  {
    question: "Les rapports sont-ils officiels ?",
    answer: "Oui, tous les rapports publiés sur cette plateforme sont des documents officiels validés par les ministères et institutions concernés."
  },
  {
    question: "À quelle fréquence les rapports sont-ils mis à jour ?",
    answer: "Les rapports sont publiés dès leur validation par les autorités compétentes. La plateforme est mise à jour régulièrement pour refléter les dernières publications."
  },
  {
    question: "Puis-je télécharger les rapports ?",
    answer: "Oui, chaque rapport peut être consulté en ligne et téléchargé au format PDF pour une lecture hors ligne."
  },
  {
    question: "Comment puis-je soumettre un rapport ?",
    answer: "Seules les institutions gouvernementales autorisées peuvent publier des rapports. Si vous représentez une institution, veuillez contacter l'administration de la plateforme."
  }
]

export default function FAQ() {
  const [activeIndex, setActiveIndex] = useState(null)

  const toggleFAQ = (index) => {
    setActiveIndex(activeIndex === index ? null : index)
  }

  return (
    <section id="faq">
      <div className="container">
        <h2 className="section-title">Questions Fréquentes</h2>
        <div className="faq-container">
          {faqData.map((faq, index) => (
            <div
              key={index}
              className={`faq-item ${activeIndex === index ? 'active' : ''}`}
            >
              <div className="faq-question" onClick={() => toggleFAQ(index)}>
                <span>{faq.question}</span>
                <i className="fas fa-chevron-down"></i>
              </div>
              <div className="faq-answer">
                <p>{faq.answer}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
