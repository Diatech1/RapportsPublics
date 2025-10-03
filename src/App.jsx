import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Header from './components/Header'
import Footer from './components/Footer'
import Home from './pages/Home'
import Reports from './pages/Reports'
import ReportDetail from './pages/ReportDetail'
import './App.css'

function App() {
  return (
    <Router>
      <Header />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/rapports" element={<Reports />} />
        <Route path="/rapport/:slug" element={<ReportDetail />} />
      </Routes>
      <Footer />
    </Router>
  )
}

export default App
