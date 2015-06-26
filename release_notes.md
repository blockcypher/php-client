BlockCypher PHP SDK release notes
=================================

v1.0.0
------

* Added TXRefTest::received property
* Renamed TXConfidence::age_seconds TXConfidence::age_millis
* Added BtcConverter
* Added TokenValidator
* Added BlockCypherCoinSymbolConstants
* Added missing property TX::next_inputs
* Added Wallet API
* Get wallet as address
* Get wallet balance as address balance
* Get full wallet as full address
* Allow create, sign and send transactions
* Added docs site samples for Blockchain API and Address API (without wallets and multisign endpoint)
* Added Payment API
* Added Microtransaction API
* Added Decode Raw Transaction Endpoint
* Added Push Raw Transaction Endpoint
* Multisign txs (fund and spend)
* Improved usability for MicroTX
* Extracted methods from MicroTX to MicroTXClient

v1.0.0-beta
-----------

* Allow getting token from config ini file
* Removed FINE log level
* Added BlockCypherBaseModel. Base model class with error and errors properties
* Added TXConfidence class
* Added Address:getAllTxrefs method

v0.6.0
------
* Added address generation
* Added sample to get a block by height
* Added batching for blocks
* Added batching for addresses
* Added batching for transactions
* Allows getting only address balance
* Allows getting full address
* Added URL params 'unspentOnly' and 'before' to Address
* Added URL params 'unspentOnly' and 'before' to FullAddress
* Added URL params 'txstart' and 'limit' to Block
* Added URL params 'instart', 'outstart' and 'limit' to TX
* Added WebHook API endpoint
* Added 'params' parameter to all GET methods to allow add URL parameters in the future without breaking method signature

v0.5.0
------
* Initial Release