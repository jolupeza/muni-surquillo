<?php

use Endroid\SimpleExcel\SimpleExcel;

/**
 * Description of postulantesController.
 *
 * @author jperez
 */
class contactsController extends Controller
{
    private $excel;
    private $headers;

    public function __construct()
    {
        parent::__construct();
        $this->headers = array();
    }

    public function index()
    {
        echo '';
    }

    public function generateExcel()
    {
        $this->excel = new SimpleExcel();
        $objPHPExcel = new PHPExcel();

        $filename = 'contactos.xls';

        $title = 'Relación de Contactos';

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Contactos');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

        $this->generateHeaderExcel($objPHPExcel);
        $this->generateCellsExcel($objPHPExcel);

//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type XLSX
        header('Content-Type: application/vnd.ms-excel'); //mime type XLS
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

//        $this->excel->loadFromArray(array('Postulantes' => $data));
//        $this->excel->saveToOutput($filename, array('Postulantes'));
    }

    private function generateHeaderExcel(PHPExcel $excel)
    {
        $headers = $this->setHeaders();

        if (count($headers)) {
            foreach ($headers as $key => $value) {
                $excel->getActiveSheet()->setCellValue($key, $value);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setSize(11);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
    }

    private function setHeaders()
    {
        $this->headers = array(
            'A3' => 'Nombre',
            'B3' => 'Correo electrónico',
            'C3' => 'Teléfono',
            'D3' => 'Dirección',
            'E3' => 'Urbanización',
            'F3' => 'Asunto',
            'G3' => 'Fecha'
        );

        return $this->headers;
    }

    private function generateCellsExcel(PHPExcel $excel)
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'contacts',
        );

        $i = 4;
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $id = get_the_ID();
                $values = get_post_custom($id);

                $name = (isset($values['mb_name'])) ? esc_attr($values['mb_name'][0]) : '';
                $lastname = (isset($values['mb_lastname'])) ? esc_attr($values['mb_lastname'][0]) : '';
                $email = (isset($values['mb_email'])) ? esc_attr($values['mb_email'][0]) : '';
                $phone = (isset($values['mb_phone'])) ? esc_attr($values['mb_phone'][0]) : '';
                $address = (isset($values['mb_address'])) ? esc_attr($values['mb_address'][0]) : '';
                $urba = (isset($values['mb_urba'])) ? esc_attr($values['mb_urba'][0]) : '';
                $message = (isset($values['mb_message'])) ? esc_attr($values['mb_message'][0]) : '';
                
                $subject = get_the_terms($id, 'subjects')[0]->name;

                $excel->getActiveSheet()->setCellValue('A'.$i, "$name $lastname");
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('B'.$i, $email);
                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('C'.$i, $phone);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('D'.$i, $address);
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('E'.$i, $urba);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);
                
                $excel->getActiveSheet()->setCellValue('F'.$i, $subject);
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('G'.$i, get_the_time('d-m-Y'));
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);

//                $excel->getActiveSheet()->setCellValue('G'.$i, $datePostulation);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
//                $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                ++$i;
            }
        }
        wp_reset_postdata();
    }
}
