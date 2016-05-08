<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( isset( $_POST['template-contactform-submit'] ) AND $_POST['template-contactform-submit'] == 'submit' ) {
    if( $_POST['template-contactform-name'] != '' AND $_POST['template-contactform-email'] != '' AND $_POST['template-contactform-message'] != '' ) {

        $name = $_POST['template-contactform-name'];
        $email = $_POST['template-contactform-email'];
        $phone = $_POST['template-contactform-phone'];
        $empresa = $_POST['template-contactform-empresa'];
        $message = $_POST['template-contactform-message'];

        $subject = isset($subject) ? $subject : 'New Message From Contact Form';

        $botcheck = $_POST['template-contactform-botcheck'];

        $toemail = 'vitorhf@gmail.com'; // Your Email Address
        $toname = 'Vitor'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = 'Contato enviado pelo site www.capacitesuaequipe.com.br';

            $name = isset($name) ? "Nome: $name<br><br>" : '';
            $email = isset($email) ? "E-mail: $email<br><br>" : '';
            $phone = isset($phone) ? "Telefone: $phone<br><br>" : '';
            $empresa = isset($empresa) ? "Empresa: $empresa<br><br>" : '';
            $message = isset($message) ? "Message: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Contato enviado pelo site: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $empresa $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                echo 'Nós recebmos com <strong>sucesso</strong> sua mensagem e retornaremos assim que possível.';
            else:
                echo 'E-mail <strong>não pode</strong> ser entregue por ter acontecido algum erro inesperado. Por favor tente mais tarde.<br /><br /><strong>Motivo:</strong><br />' . $mail->ErrorInfo . '';
            endif;
        } else {
            echo 'Bot <strong>detactado</strong>.! ';
        }
    } else {
        echo 'Por favor <strong>preencha</strong> todos os campos obrigatórios e envie novamente.';
    }
} else {
    echo 'Um <strong>erro inesperado</strong> ocorreu. Por favor tente mais tarde.';
}

?>