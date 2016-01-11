<pre>
    <?php

    class Cupon_Reducere_IndexController extends Mage_Core_Controller_Front_Action {

        public function indexAction() {

            $date = Mage::getModel('Cupon_Reducere/sales_flat_order');

            $collection = $date->getCollection();
            foreach ($collection as $date_to) {
                print_r($date_to->getData());
                print_r($date_to->getDateTo());
            }
        }

        public function modelsAction() {
            $comenzi = 0;
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $customerData = Mage::getSingleton('customer/session')->getCustomer();
                $id_customer = $customerData->getId();
                $mail_customer = $customerData->getEmail();

                $connection = Mage::getModel('core/resource')->getConnection('core_read');
                $sql = 'SELECT * FROM `sales_flat_order`';
                $orders = $connection->fetchAll($sql);
                
                //se verifica numarul de comenzi
                foreach ($orders as $key) {

                    if ($key[customer_id] == $id_customer)
                        $comenzi++;
                }
                
                //daca e prima comanda
                if ($comenzi == 1) {
                    //Email information
                    $admin_email = "broatec.mihai@gmail.com";
                    $email = $mail_customer;
                    $subject = "Reducere de 20% la urmatoarea comanda";
                    $comment = "Ati primit o reducere de 20% la urmatoarea comanda. Codul de reducere este: BDG34F";

                    //send email
                    mail($admin_email, "$subject", $comment, "From:" . $email);
                    echo "Email-ul a fost trimis!";
                    
                } else
                    echo "<br>Nu se trimite mail cu reducere!";
            }
        }

    }
    