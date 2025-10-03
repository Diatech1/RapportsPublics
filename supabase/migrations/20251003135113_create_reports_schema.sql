/*
  # Create Reports Schema for Rapports Publics Sénégal

  ## Overview
  This migration creates the complete database schema for the Senegalese public reports repository system.

  ## New Tables

  ### 1. `ministeres` (Ministries)
  - `id` (uuid, primary key) - Unique identifier
  - `name` (text) - Ministry name
  - `slug` (text, unique) - URL-friendly identifier
  - `description` (text) - Ministry description
  - `created_at` (timestamptz) - Creation timestamp

  ### 2. `report_categories` (Report Categories)
  - `id` (uuid, primary key) - Unique identifier
  - `name` (text) - Category name
  - `slug` (text, unique) - URL-friendly identifier
  - `description` (text) - Category description
  - `created_at` (timestamptz) - Creation timestamp

  ### 3. `reports` (Public Reports)
  - `id` (uuid, primary key) - Unique identifier
  - `title` (text) - Report title
  - `slug` (text, unique) - URL-friendly identifier
  - `excerpt` (text) - Brief description
  - `content` (text) - Full report content
  - `ministere_id` (uuid) - Foreign key to ministeres
  - `category_id` (uuid) - Foreign key to report_categories
  - `publication_date` (date) - Official publication date
  - `file_url` (text) - PDF file URL
  - `file_size` (text) - Human-readable file size
  - `download_count` (integer, default 0) - Number of downloads
  - `image_url` (text) - Cover image URL
  - `created_at` (timestamptz) - Creation timestamp
  - `updated_at` (timestamptz) - Last update timestamp

  ## Security
  - All tables have RLS enabled
  - Public read access for all reports and metadata
  - Insert/update/delete restricted to authenticated users only

  ## Indexes
  - Created indexes on frequently queried columns (slug, ministere_id, category_id)
  - Created index on publication_date for sorting

  ## Notes
  - Uses gen_random_uuid() for auto-generating UUIDs
  - Cascading deletes for referential integrity
  - Timestamps automatically managed
*/

-- Create ministeres table
CREATE TABLE IF NOT EXISTS ministeres (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name text NOT NULL,
  slug text UNIQUE NOT NULL,
  description text DEFAULT '',
  created_at timestamptz DEFAULT now()
);

-- Create report_categories table
CREATE TABLE IF NOT EXISTS report_categories (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name text NOT NULL,
  slug text UNIQUE NOT NULL,
  description text DEFAULT '',
  created_at timestamptz DEFAULT now()
);

-- Create reports table
CREATE TABLE IF NOT EXISTS reports (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  title text NOT NULL,
  slug text UNIQUE NOT NULL,
  excerpt text DEFAULT '',
  content text DEFAULT '',
  ministere_id uuid REFERENCES ministeres(id) ON DELETE SET NULL,
  category_id uuid REFERENCES report_categories(id) ON DELETE SET NULL,
  publication_date date DEFAULT CURRENT_DATE,
  file_url text DEFAULT '',
  file_size text DEFAULT '',
  download_count integer DEFAULT 0,
  image_url text DEFAULT '',
  created_at timestamptz DEFAULT now(),
  updated_at timestamptz DEFAULT now()
);

-- Create indexes for better query performance
CREATE INDEX IF NOT EXISTS idx_reports_slug ON reports(slug);
CREATE INDEX IF NOT EXISTS idx_reports_ministere ON reports(ministere_id);
CREATE INDEX IF NOT EXISTS idx_reports_category ON reports(category_id);
CREATE INDEX IF NOT EXISTS idx_reports_publication_date ON reports(publication_date DESC);

-- Enable Row Level Security
ALTER TABLE ministeres ENABLE ROW LEVEL SECURITY;
ALTER TABLE report_categories ENABLE ROW LEVEL SECURITY;
ALTER TABLE reports ENABLE ROW LEVEL SECURITY;

-- RLS Policies for ministeres
CREATE POLICY "Anyone can view ministeres"
  ON ministeres FOR SELECT
  USING (true);

CREATE POLICY "Authenticated users can insert ministeres"
  ON ministeres FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update ministeres"
  ON ministeres FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete ministeres"
  ON ministeres FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for report_categories
CREATE POLICY "Anyone can view report categories"
  ON report_categories FOR SELECT
  USING (true);

CREATE POLICY "Authenticated users can insert categories"
  ON report_categories FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update categories"
  ON report_categories FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete categories"
  ON report_categories FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for reports
CREATE POLICY "Anyone can view reports"
  ON reports FOR SELECT
  USING (true);

CREATE POLICY "Authenticated users can insert reports"
  ON reports FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update reports"
  ON reports FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete reports"
  ON reports FOR DELETE
  TO authenticated
  USING (true);

-- Insert sample ministeres
INSERT INTO ministeres (name, slug, description) VALUES
  ('Ministère de la Santé', 'ministere-sante', 'Ministère de la Santé et de l''Action Sociale'),
  ('Ministère de l''Éducation', 'ministere-education', 'Ministère de l''Éducation Nationale'),
  ('Ministère des Finances', 'ministere-finances', 'Ministère de l''Économie, du Plan et de la Coopération'),
  ('Ministère de l''Intérieur', 'ministere-interieur', 'Ministère de l''Intérieur et de la Sécurité Publique')
ON CONFLICT (slug) DO NOTHING;

-- Insert sample categories
INSERT INTO report_categories (name, slug, description) VALUES
  ('Rapport Annuel', 'rapport-annuel', 'Rapports annuels des activités'),
  ('Audit', 'audit', 'Rapports d''audit et de contrôle'),
  ('Étude', 'etude', 'Études et recherches'),
  ('Budget', 'budget', 'Documents budgétaires')
ON CONFLICT (slug) DO NOTHING;

-- Insert sample reports
INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Rapport Annuel 2024 - Santé Publique',
  'rapport-annuel-2024-sante',
  'Bilan complet des activités du ministère de la santé pour l''année 2024',
  'Rapport détaillé sur les réalisations et défis du secteur de la santé au Sénégal.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-sante'),
  (SELECT id FROM report_categories WHERE slug = 'rapport-annuel'),
  '2024-12-31',
  '2.4 MB',
  'https://images.pexels.com/photos/668300/pexels-photo-668300.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'rapport-annuel-2024-sante');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Audit des Programmes Éducatifs 2024',
  'audit-programmes-educatifs-2024',
  'Évaluation approfondie des programmes d''enseignement et de leurs impacts',
  'Analyse détaillée de la qualité de l''éducation et des résultats scolaires.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-education'),
  (SELECT id FROM report_categories WHERE slug = 'audit'),
  '2024-11-15',
  '3.1 MB',
  'https://images.pexels.com/photos/5212320/pexels-photo-5212320.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'audit-programmes-educatifs-2024');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Budget National 2025',
  'budget-national-2025',
  'Présentation du projet de loi de finances pour l''année 2025',
  'Document officiel présentant les orientations budgétaires pour 2025.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-finances'),
  (SELECT id FROM report_categories WHERE slug = 'budget'),
  '2024-10-01',
  '5.7 MB',
  'https://images.pexels.com/photos/6801648/pexels-photo-6801648.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'budget-national-2025');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Étude sur la Sécurité Publique 2024',
  'etude-securite-publique-2024',
  'Analyse des enjeux de sécurité et des stratégies de prévention',
  'Étude approfondie sur l''état de la sécurité publique au Sénégal.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-interieur'),
  (SELECT id FROM report_categories WHERE slug = 'etude'),
  '2024-09-20',
  '1.8 MB',
  'https://images.pexels.com/photos/8837752/pexels-photo-8837752.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'etude-securite-publique-2024');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Rapport sur la Vaccination 2024',
  'rapport-vaccination-2024',
  'Bilan des campagnes de vaccination et couverture sanitaire',
  'État des lieux complet des programmes de vaccination nationaux.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-sante'),
  (SELECT id FROM report_categories WHERE slug = 'rapport-annuel'),
  '2024-08-10',
  '1.5 MB',
  'https://images.pexels.com/photos/4386467/pexels-photo-4386467.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'rapport-vaccination-2024');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Performance Budgétaire 2023',
  'performance-budgetaire-2023',
  'Analyse de l''exécution budgétaire de l''exercice 2023',
  'Rapport détaillé sur les recettes et dépenses de l''État en 2023.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-finances'),
  (SELECT id FROM report_categories WHERE slug = 'audit'),
  '2024-07-05',
  '4.2 MB',
  'https://images.pexels.com/photos/7567443/pexels-photo-7567443.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'performance-budgetaire-2023');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Éducation Numérique au Sénégal',
  'education-numerique-senegal',
  'Étude sur l''intégration des technologies dans l''enseignement',
  'Analyse de la transformation digitale du système éducatif sénégalais.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-education'),
  (SELECT id FROM report_categories WHERE slug = 'etude'),
  '2024-06-15',
  '2.9 MB',
  'https://images.pexels.com/photos/5905510/pexels-photo-5905510.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'education-numerique-senegal');

INSERT INTO reports (title, slug, excerpt, content, ministere_id, category_id, publication_date, file_size, image_url)
SELECT
  'Stratégie Nationale de Sécurité 2024-2028',
  'strategie-securite-2024-2028',
  'Orientations stratégiques pour la sécurité nationale',
  'Document cadre définissant la politique de sécurité pour les 5 prochaines années.',
  (SELECT id FROM ministeres WHERE slug = 'ministere-interieur'),
  (SELECT id FROM report_categories WHERE slug = 'rapport-annuel'),
  '2024-05-01',
  '3.6 MB',
  'https://images.pexels.com/photos/8369648/pexels-photo-8369648.jpeg?auto=compress&cs=tinysrgb&w=800'
WHERE NOT EXISTS (SELECT 1 FROM reports WHERE slug = 'strategie-securite-2024-2028');
