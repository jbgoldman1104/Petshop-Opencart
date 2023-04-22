<?php
/**
 * class ModelPavnewsletterNewsletter
 */
class ModelPavnewsletterNewsletter extends Model {
	function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "'");
		return $query->rows;
	}
	public function installModule(){

    $this->createTableDraft();

		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavnewsletter_email'";
		$query = $this->db->query( $sql );
		if( count($query->rows) <=0 )
			$this->createTables();
	}

  // pavo 2.2 edit
  public function createTableDraft(){
    $sql_table = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavnewsletter_draft` (
                  `draft_id` int(11) NOT NULL AUTO_INCREMENT,
                  `store_id` int(11) DEFAULT '0',
                  `to` varchar(200),
                  `subject` varchar(200) DEFAULT NULL,
                  `message` text,

                  `customer_group_id` int(11) DEFAULT NULL,
                  `customer` varchar(255),
                  `affiliate` varchar(255),
                  `product` varchar(255),
                  
                  `date_added` datetime DEFAULT NULL,
                  PRIMARY KEY (`draft_id`)
                ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ";
    $sql_show = " SHOW TABLES LIKE '".DB_PREFIX."pavnewsletter_draft'";
    $query = $this->db->query( $sql_show );
    if(count($query->rows)<=0){
      $query = $this->db->query( $sql_table );
    }
  }
  // pavo 2.2 end edit 

	protected function createTables(){
		$sql = array();

		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavnewsletter_email` (
                  `email_id` int(11) NOT NULL AUTO_INCREMENT,
                  `template_id` int(11) DEFAULT NULL,
                  `language_id` int(11) DEFAULT NULL,
                  `subject` varchar(200) DEFAULT NULL,
                  `attach` varchar(200),
                  `message` text,
                  `customer_group_id` int(11) DEFAULT NULL,
                  `affiliate` varchar(255),
                  `customer` varchar(255),
                  `product` varchar(255),
                  `defined` varchar(255),
                  `special` varchar(255),
                  `latest` varchar(255),
                  `popular` varchar(255),
                  `defined_categories` varchar(255),
                  `categories` varchar(255) DEFAULT NULL,
                  `defined_products` varchar(255),
                  `defined_products_more` varchar(255),
                  `only_selected_language` int(11) DEFAULT NULL,
                  `store_id` int(11) DEFAULT NULL,
                  `to` varchar(200),
                  `date_added` datetime DEFAULT NULL,
                  PRIMARY KEY (`email_id`)
                ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

		";
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavnewsletter_subscribe` (
                      `subscribe_id` int(11) NOT NULL AUTO_INCREMENT,
                      `customer_id` int(11) DEFAULT '0',
                      `store_id` int(11) DEFAULT NULL,
                      `email` varchar(200) DEFAULT NULL,
                      `action` tinyint(4) DEFAULT '1',
                      PRIMARY KEY (`subscribe_id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
		";
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavnewsletter_template` (
                  `template_id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(200) DEFAULT NULL,
                  `hits` tinyint(4) DEFAULT '0',
                  `template_file` varchar(200) DEFAULT NULL,
                  `is_default` tinyint(1) DEFAULT '0',
                  `date_added` datetime DEFAULT NULL,
                  `ordering` int(11) DEFAULT NULL,
                  `date_modified` datetime DEFAULT NULL,
                  PRIMARY KEY (`template_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ";
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavnewsletter_template_description` (
                  `template_id` int(11) DEFAULT NULL,
                  `language_id` int(11) DEFAULT NULL,
                  `subject` varchar(200) DEFAULT NULL,
                  `template_message` text
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
				
		$sql[] = "CREATE TABLE `".DB_PREFIX."pavnewsletter_history` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `language_id` int(11) NOT NULL,
				  `template_id` int(11) NOT NULL,
				  `public_id` int(11) NOT NULL,
				  `store_id` int(11) NOT NULL,
				  `to` varchar(255) NOT NULL,
				  `subject` text,
				  `message` text,
				  `date_added` datetime DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    
		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}

	}

	public function getBody($data) {
		$body = '';
		$this->load->model("pavnewsletter/template");
		$template = $this->model_pavnewsletter_template->getTemplate($data['template_id']);

     $d = array(
        'template_description' => array(),

    );

    $template = $this->model_pavnewsletter_template->getTemplate($data['template_id']);

    $template = array_merge($d,$template);

    if( empty($template['template_description']) ){ 
        $template['template_description'][$data['language_id']]['template_message']  = '{messages}';
    }


		$template_description = $template['template_description'][$data['language_id']];
    $data['message'] = str_replace( "{messages}", "", $data['message']);
		$body = str_replace( "{messages}", $data['message'], $template_description['template_message'] );
		
		$setting = array('thead' => '',
					'tprice' => $this->language->get('text_send_email_tprice'),
					'tspecial' => $this->language->get('text_send_email_tspecial'),
				);
		
		$lstproducts = $data['lstproduct'];
		
		$this->load->model("pavnewsletter/product");
		if(isset($lstproducts['selected'])) {
			$setting['thead'] = $this->language->get('text_send_email_selected');
			$html_selected = $this->model_pavnewsletter_product->genListProducts($lstproducts['selected'], $setting);
			$body = str_replace( "{products}", $html_selected, $body );
			
		} else {
			$body = str_replace( "{products}", '',$body );
		}
		if(isset($lstproducts['special'])) {
			$setting['thead'] = $this->language->get('text_send_email_special');
			$html_special = $this->model_pavnewsletter_product->genListProducts($lstproducts['special'], $setting);
			$body = str_replace( "{special}", $html_special,$body );
		} else {
			$body = str_replace( "{special}", '',$body );
		}
		if(isset($lstproducts['latest'])) {
			$setting['thead'] = $this->language->get('text_send_email_latest');
			$html_latest = $this->model_pavnewsletter_product->genListProducts($lstproducts['latest'], $setting);  
			$body = str_replace( "{latest}", $html_latest,$body );
		} else {
			$body = str_replace( "{latest}", '',$body );
		}
		if(isset($lstproducts['popular'])) {
			$setting['thead'] = $this->language->get('text_send_email_popular');
			$html_popular = $this->model_pavnewsletter_product->genListProducts($lstproducts['popular'], $setting);
			$body = str_replace( "{popular}", $html_popular,$body );
		} else {
			$body = str_replace( "{popular}", '',$body );
		}
		if(isset($lstproducts['category'])) {
			$setting['thead'] = $this->language->get('text_send_email_category');
			$html_category = $this->model_pavnewsletter_product->genListProducts($lstproducts['category'], $setting);
			$body = str_replace( "{products_form_categories}", $html_category,$body );
		} else {
			$body = str_replace( "{products_form_categories}", '',$body );
		}
    
		return $body;
	}

	
	public function send($data) {
        require_once(DIR_SYSTEM . 'library/mail_pav.php');
        
        $message  = '<html dir="ltr" lang="en">' . PHP_EOL;
        $message .= '<head>' . PHP_EOL;
        $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . PHP_EOL;
        $message .= '<title>' . $data['subject'] . '</title>' . PHP_EOL;
        $message .= '</head>' . PHP_EOL;
		$body = html_entity_decode($this->getBody($data), ENT_QUOTES, 'UTF-8');
		
		
        $message .= '<body style="padding:0;margin:0;">' . $body . '</body>' . PHP_EOL;
        $message .= '</html>' . PHP_EOL;

        $message = str_replace(array(chr(3)), '', $message);		

        $emails_count = count($data['emails']);

        $newsletter_id = $this->addHistory(array(
                            'to' => $data['to'],
                            'subject' => $data['subject'],
                            'message' => $data['message'],
                            'store_id' => $data['store_id'],
                            'template_id' => $data['template_id'],
                            'language_id' => $data['language_id'],
							'date_added' => date('Y-m-d H:i:s'),
                            'queue' => ($this->config->get('ne_throttle') && ($emails_count > $this->config->get('ne_throttle_count'))) ? 0 : $emails_count,
                            'recipients' => $emails_count
                        ));

        $attachments = array();
        $attachments_count = count($data['attachments_upload']);

        if ($attachments_count && $data['attachments_count']) {
            for ($i=0; $i < $attachments_count; $i++) {
                if (is_uploaded_file($data['attachments_upload']['attachment_'.$i]['tmp_name'])) {
                    $filename = $data['attachments_upload']['attachment_'.$i]['name'];
                    
                    $path = dirname(DIR_DOWNLOAD) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $newsletter_id;

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    if (is_dir($path)) {
                        move_uploaded_file($data['attachments_upload']['attachment_'.$i]['tmp_name'], $path . DIRECTORY_SEPARATOR . $filename);
                    }
                    
                    if (file_exists($path . DIRECTORY_SEPARATOR . $filename)) {
                        $attachments[] = array(
                            'filename' => $filename,
                            'path'     => $path . DIRECTORY_SEPARATOR . $filename
                        );
                    }
                }
            }
        }

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $store_url = (defined('HTTPS_CATALOG') ? HTTPS_CATALOG : HTTP_CATALOG);
        } else {
            $store_url = HTTP_CATALOG;
        }

        if (isset($data['store_id']) && $data['store_id'] > 0) {
            $this->load->model('setting/store');
            $store = $this->model_setting_store->getStore($this->request->post['store_id']);
            if ($store) {
                $url = rtrim($store['url'], '/') . '/';
            } else {
                $url = $store_url;
            }
        } else {
            $url = $store_url;
        }

        $dom = new DOMDocument;
		libxml_use_internal_errors(true);
        $dom->loadHTML($message);
		libxml_clear_errors();
		/*
        foreach ($dom->getElementsByTagName('a') as $node) {
            if ($node->hasAttribute('href')) {
                $link = $node->getAttribute('href');
                if ((strpos($link, 'http://') === 0) || (strpos($link, 'https://') === 0)) {
                    $add_key = ((strpos($link, '{key}') !== false) || (strpos($link, '%7Bkey%7D') !== false));
                    $node->setAttribute('href', $url );
                }
            }
        }*/
        
        $message = $dom->saveHTML();

        $this->load->model('setting/store');

        $store_info = $this->model_setting_store->getStore($data['store_id']);
        if ($store_info) {
            $store_name = $store_info['name'];
        } else {
            $store_name = $this->config->get('config_name');
        }

        $this->load->model('setting/setting');
        $store_info = $this->model_setting_setting->getSetting('config', $data['store_id']);

        foreach ($data['emails'] as $email => $info) {

            if ($this->config->get('ne_throttle')) {
                if ($emails_count > $this->config->get('ne_throttle_count')) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "ne_queue SET email = '" . $this->db->escape($email) . "', firstname = '" . $this->db->escape($info['firstname']) . "', lastname = '" . $this->db->escape($info['lastname']) . "', history_id = '" . $this->db->escape($newsletter_id) . "'");
                    continue;
                }
            }

            $mail = new Mail_PAV();
            if ($this->config->get('ne_use_smtp')) {
                $mail_config = $this->config->get('ne_smtp');
                $mail->protocol = $mail_config[$data['store_id']]['protocol'];
                $mail->parameter = $mail_config[$data['store_id']]['parameter'];
                $mail->hostname = $mail_config[$data['store_id']]['host'];
                $mail->username = $mail_config[$data['store_id']]['username'];
                $mail->password = $mail_config[$data['store_id']]['password'];
                $mail->port = $mail_config[$data['store_id']]['port'];
                $mail->timeout = $mail_config[$data['store_id']]['timeout'];
                $mail->setFrom($mail_config[$data['store_id']]['email']);
            } else {
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setFrom($store_info['config_email']);
            }
            $mail->setTo($email);
            if ($this->config->get('ne_bounce')) {
                $mail->setReturn($this->config->get('ne_bounce_email'));
            }
            $mail->setSender($store_name);

            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment['path'], $attachment['filename']);
            }

            $subject_to_send = $data['subject'];
            $message_to_send = str_replace(array('{key}', '%7Bkey%7D'), md5($this->config->get('ne_key') . $email), $message);

            if ($info) {
                $firstname = mb_convert_case($info['firstname'], MB_CASE_TITLE, 'UTF-8');
                $lastname = mb_convert_case($info['lastname'], MB_CASE_TITLE, 'UTF-8');

                $subject_to_send = str_replace(array('{name}', '{lastname}', '{email}'), array($firstname, $lastname, $email), $subject_to_send);
                $message_to_send = str_replace(array('{name}', '{lastname}', '{email}'), array($firstname, $lastname, $email), $message_to_send);

                $treward = $this->language->get("text_send_mail_treward");
				$reward = $treward . (isset($info['reward'])? $info['reward'] : 0);
				$subject_to_send = str_replace('{reward}', $reward, $subject_to_send);
				$message_to_send = str_replace('{reward}', $reward, $message_to_send);
            }
            
            
            $message_to_send = html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8');

            $mail->setSubject($subject_to_send);
            $mail->setHtml($message_to_send);

            $send_ok = $mail->send();

            $reties = (int)$this->config->get('ne_sent_retries');
            while (!$send_ok && $reties) {
                $send_ok = $mail->send();
                $reties--;
            }
        }

        if ($this->config->get('ne_throttle')) {
            if ($emails_count > $this->config->get('ne_throttle_count')) {
                $this->session->data['success'] = $this->language->get('text_throttle_success');
            } else {
                $this->session->data['success'] = $this->language->get('text_success');
            }
        } else {
            $this->session->data['success'] = $this->language->get('text_success');
        }

        if (count($data['emails']) == 1 && array_key_exists('check@isnotspam.com', $data['emails'])) {
            $this->session->data['success'] = sprintf($this->language->get('text_success_check'), $store_info['config_email']);
        }
    }
    public function addHistory($data){
        $this->db->query("INSERT INTO " . DB_PREFIX . "pavnewsletter_history SET `to` = '" . $this->db->escape($data['to']) . "', public_id = '" . $this->db->escape(md5($data['subject'] . time())). "', store_id = '" . (int)$data['store_id'] . "', template_id = '" . (int)$data['template_id'] . "', language_id = '" . (int)$data['language_id'] . "', subject = '" . $this->db->escape($data['subject']) . "', message = '" . $this->db->escape($data['message']) . "', date_added='" .$data['date_added']. "'");
        $newsletter_id = $this->db->getLastId();
        return $newsletter_id;
    }
    public function getRecipientsWithRewardPoints() {
        $query = $this->db->query("SELECT c.customer_id, c.firstname, c.lastname, c.email, cr.points FROM `" . DB_PREFIX . "customer` AS c INNER JOIN (SELECT customer_id, SUM(points) AS points FROM " . DB_PREFIX . "customer_reward GROUP BY customer_id) AS cr ON cr.customer_id = c.customer_id AND cr.points > '0' LEFT JOIN " . DB_PREFIX . "pavnewsletter_subscribe ps ON c.email = ps.email");
        return $query->rows;
    }

    public function getSubscribedRecipientsWithRewardPoints() {
        $query = $this->db->query("SELECT c.customer_id, c.firstname, c.lastname, c.email, cr.points FROM `" . DB_PREFIX . "customer` AS c INNER JOIN (SELECT customer_id, SUM(points) AS points FROM " . DB_PREFIX . "customer_reward GROUP BY customer_id) AS cr ON cr.customer_id = c.customer_id AND cr.points > '0' LEFT JOIN " . DB_PREFIX . "pavnewsletter_subscribe ps ON c.email = ps.email WHERE c.newsletter = '1'");
        return $query->rows;
    }

    public function getCustomers($data = array()) {
        $sql = "SELECT c.*, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "pavnewsletter_subscribe ps ON c.email = ps.email WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
        }

        if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
            $implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
        }

        if (!empty($data['filter_customer_group_id'])) {
            $implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
        }

        if (!empty($data['filter_ip'])) {
            $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if ($implode) {
            $sql .= " AND " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'c.email',
            'customer_group',
            'c.status',
            'c.approved',
            'c.ip',
            'c.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        //echo $sql;die();
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT DISTINCT c.* FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "pavnewsletter_subscribe ps ON c.email = ps.email WHERE c.customer_id = '" . (int)$customer_id . "'");

        return $query->row;
    }

    public function getAffiliates($data = array()) {
        $sql = "SELECT *, CONCAT(a.firstname, ' ', a.lastname) AS name, (SELECT SUM(at.amount) FROM " . DB_PREFIX . "affiliate_transaction at WHERE at.affiliate_id = a.affiliate_id GROUP BY at.affiliate_id) AS balance FROM " . DB_PREFIX . "affiliate a LEFT JOIN " . DB_PREFIX . "pavnewsletter_subscribe ps ON a.email = ps.email";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(a.firstname, ' ', a.lastname) LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "LCASE(a.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
        }

        if (!empty($data['filter_code'])) {
            $implode[] = "a.code = '" . $this->db->escape($data['filter_code']) . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "a.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "a.approved = '" . (int)$data['filter_approved'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(a.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'a.email',
            'a.code',
            'a.status',
            'a.approved',
            'a.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getAffiliate($affiliate_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate a LEFT JOIN " . DB_PREFIX . "pavnewsletter_subscribe ps ON a.email = ps.email WHERE affiliate_id = '" . (int)$affiliate_id . "'");

        return $query->row;
    }
}
