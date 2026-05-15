<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProcedimientoTupa;

class ProcedimientoTupaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procedimientos = [
            [
                'codigo' => 'TUPA-001',
                'nombre' => 'Certificado de Estudios',
                'descripcion' => 'Emisión de certificado de estudios completos',
                'costo' => 15.00,
                'dias_laborales' => 3,
                'requisitos' => [
                    'Solicitud formal',
                    'DNI del estudiante',
                    'Comprobante de pago'
                ],
                'departamento_responsable' => 'Secretaría Académica',
                'activo' => true
            ],
            [
                'codigo' => 'TUPA-002',
                'nombre' => 'Constancia de Matrícula',
                'descripcion' => 'Emisión de constancia de matrícula activa',
                'costo' => 5.00,
                'dias_laborales' => 1,
                'requisitos' => [
                    'Solicitud formal',
                    'DNI del estudiante'
                ],
                'departamento_responsable' => 'Secretaría Académica',
                'activo' => true
            ],
            [
                'codigo' => 'TUPA-003',
                'nombre' => 'Duplicado de Diploma',
                'descripcion' => 'Emisión de duplicado de diploma de egresado',
                'costo' => 25.00,
                'dias_laborales' => 5,
                'requisitos' => [
                    'Solicitud formal',
                    'DNI del egresado',
                    'Declaración jurada de pérdida',
                    'Comprobante de pago'
                ],
                'departamento_responsable' => 'Secretaría Académica',
                'activo' => true
            ],
            [
                'codigo' => 'TUPA-004',
                'nombre' => 'Licencia por Enfermedad',
                'descripcion' => 'Tramite de licencia por enfermedad del personal',
                'costo' => 0.00,
                'dias_laborales' => 2,
                'requisitos' => [
                    'Solicitud formal',
                    'Certificado médico',
                    'DNI del solicitante'
                ],
                'departamento_responsable' => 'Recursos Humanos',
                'activo' => true
            ],
            [
                'codigo' => 'TUPA-005',
                'nombre' => 'Informe de Rendimiento',
                'descripcion' => 'Solicitud de informe de rendimiento académico',
                'costo' => 10.00,
                'dias_laborales' => 2,
                'requisitos' => [
                    'Solicitud formal',
                    'DNI del estudiante',
                    'Comprobante de pago'
                ],
                'departamento_responsable' => 'Secretaría Académica',
                'activo' => true
            ]
        ];

        foreach ($procedimientos as $procedimiento) {
            ProcedimientoTupa::create($procedimiento);
        }
    }
}
