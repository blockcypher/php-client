BlockCypher PHP SDK release notes
=================================

v1.0.0
------

* Added TxrefTest::received property
* Renamed TransactionConfidence::age_seconds TransactionConfidence::age_millis
* Added BtcConverter
* Added TokenValidator
* Added BlockCypherCoinSymbolConstants
* Added missing property Transaction::next_inputs

v1.0.0-beta
-----------

* Allow getting token from config ini file
* Removed FINE log level
* Added BlockCypherBaseModel. Base model class with error and errors properties
* Added TransactionConfidence class
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
* Added URL params 'instart', 'outstart' and 'limit' to Transaction
* Added WebHook API endpoint
* Added 'params' parameter to all GET methods to allow add URL parameters in the future without breaking method signature

v0.5.0
------
* Initial Release