<?php
/**
* 	配置账号信息
*/

class WxPayConfig
{
	//=======【基本信息设置】=====================================
	//
	/**
	 * TODO: 修改这里配置为您自己申请的商户信息
	 * 微信公众号信息配置
	 * 
	 * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
	 * 
	 * MCHID：商户号（必须配置，开户邮件中可查看）
	 * 
	 * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
	 * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
	 * 
	 * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
	 * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
	 * @var string
	 */
	public $APPID = 'wx143b181a64809f15';
	public $MCHID = '1414967602';
	public $KEY = 'hotdavid113queena115yanyuhong215';
//	const APPSECRET = '7813490da6f1265e4901ffb80afaa36f';
	
	//=======【证书路径设置】=====================================
	/**
	 * TODO：设置商户证书路径
	 * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
	 * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
	 * @var path
	 */
	public $SSLCERT_PATH = '../cert/apiclient_cert.pem';
	public $SSLKEY_PATH = '../cert/apiclient_key.pem';

    public $SSLCERT = "MIIEaDCCA9GgAwIBAgIDZiY/MA0GCSqGSIb3DQEBBQUAMIGKMQswCQYDVQQGEwJDTjESMBAGA1UECBMJR3Vhbmdkb25nMREwDwYDVQQHEwhTaGVuemhlbjEQMA4GA1UEChMHVGVuY2VudDEMMAoGA1UECxMDV1hHMRMwEQYDVQQDEwpNbXBheW1jaENBMR8wHQYJKoZIhvcNAQkBFhBtbXBheW1jaEB0ZW5jZW50MB4XDTE2MTEyNDEwMDAyNloXDTI2MTEyMjEwMDAyNlowgZgxCzAJBgNVBAYTAkNOMRIwEAYDVQQIEwlHdWFuZ2RvbmcxETAPBgNVBAcTCFNoZW56aGVuMRAwDgYDVQQKEwdUZW5jZW50MQ4wDAYDVQQLEwVNTVBheTEtMCsGA1UEAxQk5LiK5rW357uD54ix572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4MREwDwYDVQQEEwgxNjYwMzQ4MDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAL8VnWq8KQFHiEKRAsgGAKKzw2NQUUoZB/U/M8QvFK0pBbtkatgtK4cnvfwkGRCE4pqzbcKApUp4HUf2D2FAM/7q2dqN0G+/G4BZaDuv/YxGtvwHSpDDOkZDkeJYs3bbrRCBcj0j9BZ9ZZjEGAb2Z8jlxQsiUDvZOJb4TuRn7IkO8v0fs/mboy2j9OTIObA+kULuoeCgELb0QuoCEE0CHmvmhlNKIQGVgzNP71dDvOut9VOvUmOFrh1r3rZZ9hXFJT70qEZj098VcVAlU1wEZxAt3rhNaWbqvKwpk/foTZx+4KHegE5QQ7ZEQiKQPU56WuqVKZHB/T9V/IKL6LWYA+0CAwEAAaOCAUYwggFCMAkGA1UdEwQCMAAwLAYJYIZIAYb4QgENBB8WHSJDRVMtQ0EgR2VuZXJhdGUgQ2VydGlmaWNhdGUiMB0GA1UdDgQWBBT9u50UEdoUwq62B31MfsKS0bGbYzCBvwYDVR0jBIG3MIG0gBQ+BSb2ImK0FVuIzWR+sNRip+WGdKGBkKSBjTCBijELMAkGA1UEBhMCQ04xEjAQBgNVBAgTCUd1YW5nZG9uZzERMA8GA1UEBxMIU2hlbnpoZW4xEDAOBgNVBAoTB1RlbmNlbnQxDDAKBgNVBAsTA1dYRzETMBEGA1UEAxMKTW1wYXltY2hDQTEfMB0GCSqGSIb3DQEJARYQbW1wYXltY2hAdGVuY2VudIIJALtUlyu8AOhXMA4GA1UdDwEB/wQEAwIGwDAWBgNVHSUBAf8EDDAKBggrBgEFBQcDAjANBgkqhkiG9w0BAQUFAAOBgQCCadLZFbCkl4RHk5AgX8P1mEBXtNsnulrifUm32HBTXLFmdDfdi3b7rbcO3ygkq12X+vmURiGBBPxQoYC3cYAn3akp9qNa6sDsW6jPVCLQASzNgiYxF1yBSispLiQEqtn++ZDb2WnHWIXHzS9f49ChJ9fa75awXDj4hVGFqwMAGw==";
    public $SSLKEY = "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC/FZ1qvCkBR4hCkQLIBgCis8NjUFFKGQf1PzPELxStKQW7ZGrYLSuHJ738JBkQhOKas23CgKVKeB1H9g9hQDP+6tnajdBvvxuAWWg7r/2MRrb8B0qQwzpGQ5HiWLN2260QgXI9I/QWfWWYxBgG9mfI5cULIlA72TiW+E7kZ+yJDvL9H7P5m6Mto/TkyDmwPpFC7qHgoBC29ELqAhBNAh5r5oZTSiEBlYMzT+9XQ7zrrfVTr1Jjha4da962WfYVxSU+9KhGY9PfFXFQJVNcBGcQLd64TWlm6rysKZP36E2cfuCh3oBOUEO2REIikD1OelrqlSmRwf0/VfyCi+i1mAPtAgMBAAECggEAFNabmyc35Y7SekfsILoe2Z93AF6i7sy6BHHHCG8F9zhRCrWRvU93vr6Dxnp9TULgn3RP1PVIkU12DAH2fWmOAg/EgEQU5grWSfH2HwQ7R0/y5ps4836G3WDDCQcZUy3zuqgTOD2ygb1dFgLUh/XZLZx5F5S/YTd4J2ae2+PFdNC/LGNraIyq/Mlkj6MTCUPvknVAPU7b3FBlhAfHV843zjK6wxaxxljgzmDOMnXJj9sLeukkQ3FDrX2D+alSIlDzyhSMmYKi0ruNTlEMxIlRJxLxb35a/76yasazZWPFsGqb+II5EXvUgXByflFN9ZhrppQPW5fVX9dDSQ2qai814QKBgQDtdsbHow+HIHxIxkHmCyPJ5loT/0EMg32M/QsA16jrxfuKXzW+Xw9PEglZDT038atXMhIpwthK/4XpkPAKkVHd3YmrOIjfVfAdDz19PpWtvRw3C34R0dXh18MiaKYa92eQ3v7Q0wFnHxWrHYF7nQ3gjDmZnfYmvPil11yYhtVjKQKBgQDOAAozJ17i8HM9CvHU+dqYtf3NS9KHAbOcA1dvwV9faED80dHyDbUxZgbYFF5rRWx8v9dJfSAu+QiK1A7Ec5y3x7SbxFiGhYzqvBxqfjaI4gUixSN/6UR9EuaG55UwKqZ3loXLXAqgXmkDc/YRNx+QuEY3YkGBV8CyUZpJ2RgXJQKBgQDKWZqN5++FcDM4OGlTRE7c70P3Il4l8a59A+vqbdtt/imZAgTkElETSgVZMyTllTQye2Jq37Q8RH2ySGWkO60NaIi1tNk9pxeTS7dUEI6vnCR863gkazDc4GVR3ucct5IzKzLsc8IQQ7bNN7lswqpenF9A/hARdppTh69J8ivH8QKBgHL7CrZqr0e0Nl5IEZtyqlS6oCNKwwOgK4RVSSSTpow2QK/c3XZhuFUOQZuyItF1OoyW96+JK8GMNvxmSKfWcA8UZPbcrRzIxlLvFF1MfVwB7CPwLVRj+1pkhk+eS2NLKwds+Nj9UuEYUT0gKKSLRA8fC/I14aI0PNZLPfciOZQRAoGBAIVzE7wm6/SAGUOt/vDeoHfd24TA6eoikV9C5/LRwFyTJSxmjjJR8mFurIvJ8THRYxvKQw5cxEX/eURJClGg/wEx36COxeKc6QV0f/JlP9oKWETp/Gk84Dn0lxbbSUiPpQjmK4az+PvkeX08TTd7Ho2idPeb5uzOEuEfqy6gow8Z";
	
	//=======【curl代理设置】===================================
	/**
	 * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
	 * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
	 * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
	 * @var unknown_type
	 */
    public $CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
    public $CURL_PROXY_PORT = 0;//8080;
	
	//=======【上报信息配置】===================================
	/**
	 * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
	 * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
	 * 开启错误上报。
	 * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
	 * @var int
	 */
    public $REPORT_LEVENL = 1;
}
