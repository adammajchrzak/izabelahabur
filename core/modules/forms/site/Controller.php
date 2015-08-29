<?php 

/*
 * formsController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 
class formsController extends Engine_Controller	{
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		$this->_forms 	= FormsModel::Instance();
	}	
	
	public function index() {
		
	}
	
	public function newsletter() {
		
		$this->_engine->_templateFile = '';
		$this->_engine->unsetToRender();
		
		if($this->_router->isAjaxRequest())	{
			
			$subject = 	"Formularz newsletter'a kontakt www.kukuczki7.pl";
					
			$body =		"Wypełniono formularz subskrybcji:\n\n";
			$body .=	"Adres e-mail: ".$_POST['newsletterEmail']."\n";
			$body .=	"--------------------------------------------------------------------------------------\n";
			$body .=	"Wiadomość wygenerowana automatycznie, nie odpowiadaj na nią!\n";
			
			$config = array('auth' => 'login', 'username' => $this->_config->email->account, 'password' => $this->_config->email->passwd);
			$tr = new Zend_Mail_Transport_Smtp($this->_config->email->server, $config);
			Zend_Mail::setDefaultTransport($tr);
			
			$mail = new Zend_Mail('utf-8');
			$mail->setBodyText($body);
			$mail->setFrom($this->_config->email->account, 'Automat newsletter');
			$mail->addTo('');
			$mail->setSubject($subject);
			$mail->send();
			
			$data = array(
				'_email'	=>	$_POST['newsletterEmail']
			);
			
			$this->_forms->saveNewsletterData($data);
		}
	}

	
	
	/*
	public function send() {
		
		$this->_engine->_templateFile = '';
		$this->_engine->unsetToRender();
		
		if($this->_router->isAjaxRequest())	{
			
			$subject = 	"Formularz kontaktowy na stronie kontakt www.pcg.pl";
					
			$body =		"Formularz kontaktowy na stronie kontakt www.pcg.pl\n\n";
			$body .=	"Imię, nazwisko: ".$_POST['contact-name']."\n";
			$body .=	"Telefon: ".$_POST['contact-phone']."\n";
			$body .=	"Adres e-mail: ".$_POST['contact-email']."\n";
			$body .=	"Treść wiadomości: ".$_POST['contact-message']."\n";
			$body .=	"--------------------------------------------------------------------------------------\n";
			$body .=	"Wiadomość wygenerowana automatycznie, nie odpowiadaj na nią!\n";
			
			$config = array('auth' => 'login', 'username' => $this->_config->email->account, 'password' => $this->_config->email->passwd);
			$tr = new Zend_Mail_Transport_Smtp($this->_config->email->server, $config);
			Zend_Mail::setDefaultTransport($tr);
			
			$mail = new Zend_Mail('utf-8');
			$mail->setBodyText($body);
			$mail->setFrom($this->_config->email->account, 'Automat formularz | pcg.pl');
			$mail->addTo('');
			$mail->setSubject($subject);
			$mail->send();
			
			$data = array(
				'_lang'		=>	'pl',
				'_email'	=>	$_POST['contact-email'],
				'_name'		=>	$_POST['contact-name'],
				'_phone'	=>	$_POST['contact-phone'],
				'_message'	=>	$_POST['contact-message']
			);
			
			$this->_forms->saveFormData($data);
		}
	}
	*/
	
	
	public function price() {
		
		$this->_engine->_templateFile = '';
		$this->_engine->unsetToRender();
		
		if($this->_router->isAjaxRequest())	{
			
			$subject = 	"Formularz zapytaj o cenę na stronie www.kukuczki7.pl";
					
			$body =		"Formularz zapytaj o cenę na stronie kontakt www.kukuczki7.pl\n\n";
			$body .=	"Imię, nazwisko: ".$_POST['fullname']."\n";
			$body .=	"Telefon: ".$_POST['phone']."\n";
			$body .=	"Adres e-mail: ".$_POST['formEmail']."\n";
                        if($_POST['room']){
                            $body   .=  "Numer lokalu: ".$_POST['room']."\n";
                        }
			$body .=	"--------------------------------------------------------------------------------------\n";
			$body .=	"Wiadomość wygenerowana automatycznie, nie odpowiadaj na nią!\n";
			
			$config = array('auth' => 'login', 'username' => $this->_config->email->account, 'password' => $this->_config->email->passwd);
			$tr = new Zend_Mail_Transport_Smtp($this->_config->email->server, $config);
			Zend_Mail::setDefaultTransport($tr);
			
			$mail = new Zend_Mail('utf-8');
			$mail->setBodyText($body);
			$mail->setFrom($this->_config->email->account, 'Automat formularz | kukuczki7.pl');
			$mail->addTo('');
			$mail->setSubject($subject);
			$mail->send();
			
			$data = array(
				'_email'	=>	$_POST['formEmail'],
				'_name'		=>	$_POST['fullname'],
				'_phone'	=>	$_POST['phone'],
				'_message'	=>	@$_POST['plname']
			);
			
			$this->_forms->saveFormData($data);
			
			/*	autoresponder */
			
			$subject = 	"Dziękujemy - www.kukuczki7.pl";
					
			$body =		"Dziękujemy za przesłanie zapytania dotyczącego naszej oferty.\nOdpowiemy na nie w ciągu 24 godzin przedstawiając konkrety na temat oferty.\n\n";
			$body .=	"--------------------------------------------------------------------------------------\n";
			$body .=	"Wiadomość wygenerowana automatycznie, nie odpowiadaj na nią!\n";
			
			$config = array('auth' => 'login', 'username' => $this->_config->email->account, 'password' => $this->_config->email->passwd);
			$tr = new Zend_Mail_Transport_Smtp($this->_config->email->server, $config);
			Zend_Mail::setDefaultTransport($tr);
			
			$mail = new Zend_Mail('utf-8');
			$mail->setBodyText($body);
			$mail->setFrom($this->_config->email->account, 'Automat formularz | kukuczki7.pl');
			$mail->addTo($_POST['formEmail']);
			$mail->setSubject($subject);
			$mail->send();
		}
	}
}
?>