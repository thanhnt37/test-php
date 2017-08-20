# General
- To create new User

        php index.php createNewUser `$userInfo`

        # $userInfo json    user informations
          caution: $userInfo type json and need to escape data

        ex: php index.php createNewUser {\"id\":\"1\"\,\"name\":\"thanhnt\"}

- To get all account of user

        php index.php getAllAccount `$userId`

        # $userId   int     id of user

        ex: php index.php getAllAccount 1

- To set deposit limit for user per day

        php index.php setDepositLimit `$userId` `$amount`

        # $userId   int     id of user
        # $amount   int     deposit limit number

        ex: php index.php setDepositLimit 1 200

- To set withdrawal limit for user per day

        php index.php setWithdrawalLimit `$userId` `$amount`

        # $userId   int     id of user
        # $amount   int     withdrawal limit number

        ex: php index.php setWithdrawalLimit 1 200

- To create account for user

        php index.php createNewAccount `$userId` `$currency`

        # $userId   int     id of user
        # $currency string  currency type of account

        ex: php index.php createNewAccount 4 usd

- To set default for user

        php index.php setDefaultAccount `$userId` `$accountId`

        # $userId    int     id of user
        # $accountId int     id of account, you can use php index.php getAllAccount `$userId` to show all account_id of user

        ex: php index.php setDefaultAccount 1 2

- To freeze account

        php index.php freezeAccount `$userId` `$accountId`

        # $userId    int     id of user
        # $accountId int     id of account, you can use php index.php getAllAccount `$userId` to show all account_id of user

        ex: php index.php freezeAccount 1 2

- To deposit into account

        php index.php deposit `$userId` `$accountId` `$amount`

        # $userId    int     id of user
        # $accountId int     id of account, you can use php index.php getAllAccount `$userId` to show all account_id of user
        # $amount    int     deposit number

        ex: php index.php deposit 1 2 100

- To withdrawal from account

        php index.php withdrawal `$userId` `$accountId` `$amount`

        # $userId    int     id of user
        # $accountId int     id of account, you can use php index.php getAllAccount `$userId` to show all account_id of user
        # $amount    int     withdrawal number

        ex: php index.php withdrawal 1 2 222

- To transfer balance between 2 account

        php index.php transfer `$userId` $accountSenderId` `$accountReceiverId` `$amount`

        # $userId            int     id of user
        # $accountSenderId   int     id of account sender
        # $accountReceiverId int     id of account will receive the balance
        # $amount            int     transfer number

        ex: php index.php transfer 1 2 4 200