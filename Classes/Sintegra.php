<?php

namespace Classes;


/**
 *
 */
class Sintegra
{
    /**
     * @return void
     */
    public static function consultCNPJ()
    {
        self::clearCookies();
        self::generateCaptcha();

        $captcha = readline("Captcha: ");
//        $cnpj = readline("CNPJ: ");
        $cnpj = "00.080.160/0001-98";
        $ch = curl_init("http://www.sintegra.fazenda.pr.gov.br/sintegra/");
        $options = array(
            CURLOPT_COOKIEJAR => __DIR__."/../cookiejar",
            CURLOPT_COOKIEFILE => __DIR__."/../cookiejar",
            CURLOPT_HTTPHEADER => [
                "Pragma: no-cache",
                "Origin: http://www.sintegra.fazenda.pr.gov.br",
                "Host: www.sintegra.fazenda.pr.gov.br",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
                "Referer: http://www.sintegra.fazenda.pr.gov.br/sintegra/sintegra1",
                "Connection: keep-alive"
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                '_method' => 'POST',
                'data[Sintegra1][CodImage]' => $captcha,
                'data[Sintegra1][Cnpj]' => $cnpj,
                'empresa' => 'Consultar Empresa',
                'data[Sintegra1][Cadicms]' => '',
                'data[Sintegra1][CadicmsProdutor]' => '',
                'data[Sintegra1][CnpjCpfProdutor]' => ''
            ],
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPAUTH => CURLAUTH_DIGEST
        );

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        if(file_exists('result.html')) {
            unlink('result.html');
        }

        $fp = fopen('result.html','x');
        fwrite($fp, html_entity_decode(utf8_encode($response)));
        fclose($fp);

        self::clearCookies();
    }

    /**
     * @return array
     */
    private static function generateCaptcha()
    {
        $ch = curl_init("http://www.sintegra.fazenda.pr.gov.br/sintegra/");
        $options = array(
            CURLOPT_HTTPHEADER => [
                "Pragma: no-cache",
                "Origin: http://www.sintegra.fazenda.pr.gov.br",
                "Host: www.sintegra.fazenda.pr.gov.br",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
                "Accept-Encoding: gzip, deflate",
                "Referer: http://www.sintegra.fazenda.pr.gov.br/sintegra/sintegra1",
                "Connection: keep-alive"
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_COOKIEFILE => __DIR__."/../cookiejar",
            CURLOPT_COOKIEJAR => __DIR__."/../cookiejar"
        );

        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);

        $ch = curl_init("http://www.sintegra.fazenda.pr.gov.br/sintegra/captcha?".self::random(2));
        $options = array(
            CURLOPT_HTTPHEADER => [
                "Pragma: no-cache",
                "Origin: http://www.sintegra.fazenda.pr.gov.br",
                "Host: www.sintegra.fazenda.pr.gov.br",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
                "Accept-Encoding: gzip, deflate",
                "Referer: http://www.sintegra.fazenda.pr.gov.br/sintegra/sintegra1",
                "Connection: keep-alive"
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_COOKIEFILE => __DIR__."/../cookiejar",
            CURLOPT_COOKIEJAR => __DIR__."/../cookiejar"
        );

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        self::saveCaptcha($response);
    }

    /**
     * @param $img
     * @param $name
     * @return void
     */
    private static function saveCaptcha($img, $name = 'captcha.jpeg')
    {
        if(file_exists($name)) {
            unlink($name);
        }

        $fp = fopen($name,'x');
        fwrite($fp, $img);
        fclose($fp);
    }

    /**
     * @param $multiplier
     * @return float
     */
    private static function random($multiplier = 1)
    {
        return ((float)rand() / (float)getrandmax()) * $multiplier;
    }

    /**
     * @return void
     */
    private static function clearCookies()
    {
        if(file_exists(__DIR__."/../cookiejar")) {
            unlink(__DIR__."/../cookiejar");
        }
    }
}