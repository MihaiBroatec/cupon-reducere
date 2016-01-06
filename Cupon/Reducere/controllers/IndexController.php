<pre>
    <?php

    class Cupon_Reducere_IndexController extends Mage_Core_Controller_Front_Action {

        public function indexAction() {
            echo "esti in index<br>";
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
            }
            
            $connection = Mage::getModel('core/resource')->getConnection('core_read');
            $sql = 'SELECT * FROM `sales_flat_order`';
            $orders = $connection->fetchAll($sql);
            //print_r($orders);

            foreach ($orders as $key) {
                
                 if ($key[customer_id] == $id_customer) $comenzi++;
            }
            echo "Clientul cu id-ul:".$id_customer." are ".$comenzi." comenzi"; 
            if($comenzi==1) echo "<br>Trimite mail cu reducerea";
            else echo "<br>nu trimite mail";
        }

    }
    