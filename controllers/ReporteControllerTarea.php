<?php
// controllers/ReportController.php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

use Shuchkin\SimpleXLSXGen;

class ReporteControllerTarea {
    private $tarea;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->tarea = new Tarea($this->db);
    }

    public function reportePdf() {
        try {
            // Obtener tareas
            $result = $this->tarea->obtenerTareas();
            $tareas = $result->fetchAll(PDO::FETCH_ASSOC);

            // Configurar DOMPDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            // Crear instancia de DOMPDF
            $dompdf = new Dompdf($options);

            // Preparar el HTML
            $html = $this->generatePDFTemplate($tareas);

            // Cargar HTML
            $dompdf->loadHtml($html);

            // Configurar papel y orientación
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar PDF
            $dompdf->render();

            // Nombre del archivo
            $filename = 'reporte_tareas_' . date('Y-m-d_H-i-s') . '.pdf';

            // Enviar al navegador
            $dompdf->stream($filename, array('Attachment' => true));

        } catch (Exception $e) {
            echo "Error al generar PDF: " . $e->getMessage();
        }
    }

    private function generatePDFTemplate($tareas) {
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Tareas</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f8f9fa;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                .header h1 {
                    color: #333;
                    margin: 0;
                    padding: 10px 0;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 10px;
                    color: #666;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Reporte de Tareas</h1>
                <p>Sistema de Gestión de Tareas</p>
            </div>
            
            <div class="date">
                Fecha de generación: ' . date('d/m/Y H:i:s') . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha Límite</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($tareas as $tarea) {
            $html .= '
                <tr>
                    <td>' . $tarea['id'] . '</td>
                    <td>' . htmlspecialchars($tarea['titulo']) . '</td>
                    <td>' . htmlspecialchars($tarea['descripcion']) . '</td>
                    <td>' . htmlspecialchars($tarea['estado']) . '</td>
                    <td>' . $tarea['fecha_inicio'] . '</td>
                    <td>' . $tarea['fecha_limite'] . '</td>
                </tr>';
        }

        $html .= '
                </tbody>
            </table>

            <div class="footer">
                <p>Este reporte fue generado automáticamente.</p>
                <p>Página 1 de 1</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
