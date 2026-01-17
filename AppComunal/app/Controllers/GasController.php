<?php

namespace App\Controllers;

use App\Models\RegistroGasModel;
use App\Models\DetalleSolicitudModel;
use App\Models\PrecioModel;
use App\Models\LiderModel;

class GasController extends BaseController
{
    /**
     * Procesa la carga masiva de la jornada de gas.
     * Recibe un array de líderes y sus cilindros desde el Frontend.
     */
    public function procesarJornada()
    {
        $regModel = new RegistroGasModel();
        $detModel = new DetalleSolicitudModel();
        $preModel = new PrecioModel();

        // 1. Obtener los precios vigentes para el cálculo matemático
        $precios = $preModel->orderBy('id', 'DESC')->first();
        
        if (!$precios) {
            return "Error: No hay precios configurados en el sistema.";
        }

        // 2. Crear la cabecera de la Jornada (Registro principal)
        $idJornada = $regModel->insert([
            'descripcion_jornada'   => $this->request->getPost('descripcion') ?? 'Jornada ' . date('d-m-Y'),
            'fecha_creacion'        => date('Y-m-d H:i:s'),
            'monto_total_comunidad' => 0 
        ]);

        // 3. Recibir los datos del Frontend (Se espera un array 'lideres')
        // Estructura esperada: lideres[ID_LIDER][cant_10, cant_18, cant_43]
        $lideresInput = $this->request->getPost('lideres');
        $granTotalComunidad = 0;

        if ($lideresInput) {
            foreach ($lideresInput as $idLider => $cantidades) {
                
                // CÁLCULO MATEMÁTICO (Igual a tu reporte físico)
                $subtotal = ($cantidades['c10'] * $precios['precio_10kg']) + 
                            ($cantidades['c18'] * $precios['precio_18kg']) + 
                            ($cantidades['c43'] * $precios['precio_43kg']);

                // 4. Guardar el desglose por cada líder
                $detModel->insert([
                    'id_registro'   => $idJornada,
                    'id_lider'      => $idLider,
                    'cant_10kg'     => $cantidades['c10'],
                    'cant_18kg'     => $cantidades['c18'],
                    'cant_43kg'     => $cantidades['c43'],
                    'subtotal_pago' => $subtotal
                ]);

                $granTotalComunidad += $subtotal;
            }
        }

        // 5. Actualizamos el monto total en la cabecera
        $regModel->update($idJornada, ['monto_total_comunidad' => $granTotalComunidad]);

        return redirect()->to("gas/reporte/$idJornada");
    }

    /**
     * Genera la data para el consolidado final (El reporte de tu foto)
     */
    public function verReporte($idJornada)
    {
        $regModel = new RegistroGasModel();
        $detModel = new DetalleSolicitudModel();

        $data['jornada']  = $regModel->find($idJornada);
        $data['detalles'] = $detModel->obtenerDetallesPorJornada($idJornada);

        // Cálculos para el pie de página del reporte
        $data['totales_cilindros'] = [
            't10' => array_sum(array_column($data['detalles'], 'cant_10kg')),
            't18' => array_sum(array_column($data['detalles'], 'cant_18kg')),
            't43' => array_sum(array_column($data['detalles'], 'cant_43kg')),
        ];

        return view('gas/reporte_final', $data);
    }
}