<?php

// File generated from our OpenAPI spec

namespace Stripe;

/**
 * You can add one or multiple tax IDs to a <a
 * href="https://stripe.com/docs/api/customers">customer</a>. A customer's tax IDs
 * are displayed on invoices and credit notes issued for the customer.
 *
 * Related guide: <a href="https://stripe.com/docs/billing/taxes/tax-ids">Customer
 * Tax Identification Numbers</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property null|string $country Two-letter ISO code representing the country of the tax ID.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property null|string|\Stripe\Customer $customer ID of the customer.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property string $type Type of the tax ID, one of <code>ae_trn</code>, <code>au_abn</code>, <code>br_cnpj</code>, <code>br_cpf</code>, <code>ca_bn</code>, <code>ca_qst</code>, <code>ch_gst</code>, <code>cl_tin</code>, <code>es_cif</code>, <code>eu_gst</code>, <code>hk_br</code>, <code>id_npwp</code>, <code>in_gst</code>, <code>jp_cn</code>, <code>kr_brn</code>, <code>li_uid</code>, <code>mx_rfc</code>, <code>my_frp</code>, <code>my_itn</code>, <code>my_sst</code>, <code>no_gst</code>, <code>nz_gst</code>, <code>ru_inn</code>, <code>sa_gst</code>, <code>sg_gst</code>, <code>sg_uen</code>, <code>th_gst</code>, <code>tw_gst</code>, <code>us_ein</code>, or <code>za_gst</code>. Note that some legacy tax IDs have type <code>unknown</code>
 * @property string $value Value of the tax ID.
 * @property null|\Stripe\StripeObject $verification Tax ID verification information.
 */
class TaxId extends ApiResource
{
    const OBJECT_NAME = 'tax_id';

    use ApiOperations\Delete;

    const TYPE_AE_TRN = 'ae_trn';
    const TYPE_AU_ABN = 'au_abn';
    const TYPE_BR_CNPJ = 'br_cnpj';
    const TYPE_BR_CPF = 'br_cpf';
    const TYPE_CA_BN = 'ca_bn';
    const TYPE_CA_QST = 'ca_qst';
    const TYPE_CH_gst = 'ch_gst';
    const TYPE_CL_TIN = 'cl_tin';
    const TYPE_ES_CIF = 'es_cif';
    const TYPE_EU_gst = 'eu_gst';
    const TYPE_HK_BR = 'hk_br';
    const TYPE_ID_NPWP = 'id_npwp';
    const TYPE_IN_GST = 'in_gst';
    const TYPE_JP_CN = 'jp_cn';
    const TYPE_KR_BRN = 'kr_brn';
    const TYPE_LI_UID = 'li_uid';
    const TYPE_MX_RFC = 'mx_rfc';
    const TYPE_MY_FRP = 'my_frp';
    const TYPE_MY_ITN = 'my_itn';
    const TYPE_MY_SST = 'my_sst';
    const TYPE_NO_gst = 'no_gst';
    const TYPE_NZ_GST = 'nz_gst';
    const TYPE_RU_INN = 'ru_inn';
    const TYPE_SA_gst = 'sa_gst';
    const TYPE_SG_GST = 'sg_gst';
    const TYPE_SG_UEN = 'sg_uen';
    const TYPE_TH_gst = 'th_gst';
    const TYPE_TW_gst = 'tw_gst';
    const TYPE_UNKNOWN = 'unknown';
    const TYPE_US_EIN = 'us_ein';
    const TYPE_ZA_gst = 'za_gst';

    const VERIFICATION_STATUS_PENDING = 'pending';
    const VERIFICATION_STATUS_UNAVAILABLE = 'unavailable';
    const VERIFICATION_STATUS_UNVERIFIED = 'unverified';
    const VERIFICATION_STATUS_VERIFIED = 'verified';

    /**
     * @return string the API URL for this tax id
     */
    public function instanceUrl()
    {
        $id = $this['id'];
        $customer = $this['customer'];
        if (!$id) {
            throw new Exception\UnexpectedValueException(
                "Could not determine which URL to request: class instance has invalid ID: {$id}"
            );
        }
        $id = Util\Util::utf8($id);
        $customer = Util\Util::utf8($customer);

        $base = Customer::classUrl();
        $customerExtn = \urlencode($customer);
        $extn = \urlencode($id);

        return "{$base}/{$customerExtn}/tax_ids/{$extn}";
    }

    /**
     * @param array|string $_id
     * @param null|array|string $_opts
     *
     * @throws \Stripe\Exception\BadMethodCallException
     */
    public static function retrieve($_id, $_opts = null)
    {
        $msg = 'Tax IDs cannot be retrieved without a customer ID. Retrieve ' .
               "a tax ID using `Customer::retrieveTaxId('customer_id', " .
               "'tax_id_id')`.";

        throw new Exception\BadMethodCallException($msg);
    }
}
