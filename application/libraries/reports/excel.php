<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class excel {

    private $excel;

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH . 'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }

    public function save($path) {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    public function stream_for_moremint($filename, $data = null) {
        if ($data != null) {
            $col = 'A';
            foreach ($data[0] as $key => $val) {
                $objRichText = new PHPExcel_RichText();
                $objPayable = $objRichText->createTextRun(str_replace("_", " ", $val));
                $objPayable->getFont()->setBold(true);
                $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKRED));
                $this->excel->getActiveSheet()->getCell($col . '1')->setValue($objRichText);
                //$objPHPExcel->getActiveSheet()->setCellValue($col.'1' , str_replace("_"," ",$key));
                $col++;
            }
            $rowNumber = 2; //start in cell 1
            unset($data[0]);
            foreach ($data as $row) {

                $col = 'A'; // start at column A
                foreach ($row as $cell) {
                    $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
                    $col++;
                }
                $rowNumber++;
            }
        }
//        header('Content-type: application/ms-excel');
//        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
//        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
       // $objWriter->save('php://output');
        $objWriter->save("temp/$filename");
//        header("location: " . base_url() . "uploads/$filename");
//        unlink(base_url() . "uploads/$filename");
    }

    public function dailyTaskReporting($filename, $data = null, $export = FALSE) {
        $rowNumber = 1; //start in cell 1
        foreach ($data['r_report'] as $eachRow) {
            $col = "A";
            if (!is_array($eachRow)) {
                continue;
            }
            foreach ($eachRow as $eachCellValue) {
                $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $eachCellValue);
                $col++;
            }
            $rowNumber++;
        }
        if ($export == FALSE) {
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            $objWriter->save(SITE_ROOT_PATH . "/uploads/temp_reports/$filename");
        } else {
            header('Content-type: application/ms-excel');
            header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
            header("Cache-control: private");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            $objWriter->save("temp/$filename");
            header("location: " . base_url() . "temp/$filename");
            unlink(base_url() . "temp/$filename");
        }
    }

    public function stream($filename, $data = null) {
        if ($data != null) {
            $col = 'A';
            foreach ($data[0] as $key => $val) {
                $objRichText = new PHPExcel_RichText();
                $objPayable = $objRichText->createTextRun(str_replace("_", " ", $key));
                $objPayable->getFont()->setBold(true);
                $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKRED));
                $this->excel->getActiveSheet()->getCell($col . '1')->setValue($objRichText);
                //$objPHPExcel->getActiveSheet()->setCellValue($col.'1' , str_replace("_"," ",$key));
                $col++;
            }
            $rowNumber = 2; //start in cell 1
            foreach ($data as $row) {
                $col = 'A'; // start at column A
                foreach ($row as $cell) {
                    $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
                    $col++;
                }
                $rowNumber++;
            }
        }
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        $objWriter->save("temp/$filename");
        header("location: " .UPLOAD. "temp/$filename");
        //unlink(base_url() . "temp/$filename");
    }

    public function __call($name, $arguments) {
        // make sure our child object has this method  
        if (method_exists($this->excel, $name)) {
            // forward the call to our child object  
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }

}
