<?php
/**
 * PostFinance Checkout SDK
 *
 * This library allows to interact with the PostFinance Checkout payment service.
 * PostFinance Checkout SDK: 1.0.0
 * 
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PostFinanceCheckout\Sdk\Model;



/**
 * TokenizationnMode model
 *
 * @category    Class
 * @description The tokenization mode controls how the tokenization of payment information is applied on the transaction.
 * @package     PostFinanceCheckout\Sdk
 * @author      customweb GmbH
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 */
class TokenizationnMode implements IEnum {

	const FORCE_UPDATE = 'FORCE_UPDATE';
	const FORCE_CREATION = 'FORCE_CREATION';
	const FORCE_CREATION_WITH_ONE_CLICK_PAYMENT = 'FORCE_CREATION_WITH_ONE_CLICK_PAYMENT';
	const ALLOW_ONE_CLICK_PAYMENT = 'ALLOW_ONE_CLICK_PAYMENT';
	

	

}
