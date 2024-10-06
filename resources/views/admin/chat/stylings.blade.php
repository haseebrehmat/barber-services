@if ($type == 'employee')
    <style>
        /* Styling for the overall chat container */
        .container-fluid.chats {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .users-list {
            flex: 0.5;
            background-color: #f2f2f2;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Styling for each user in the list */
        .user {
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .user:hover {
            background-color: #e0e0e0;
        }

        .user:last-child {
            border-bottom: none;
        }

        /* Styling for the chat box on the right side */
        .chat-box {
            flex: 2;
        }

        /* Styling for the chat container */
        .chat-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }

        /* Styling for messages */
        .message {
            max-width: 70%;
            padding: 10px;
            border-radius: 8px;
        }

        /* Styling for messages */
        .message-text {
            margin-bottom: 0px;
        }

        /* Styling for admin messages */
        .admin-message {
            background-color: #f2f2f2;
            align-self: flex-start;
        }

        /* Styling for employee messages */
        .employee-message {
            background-color: #DCF8C6;
            align-self: flex-end;
        }

        /* Styling for the username */
        .username {
            font-weight: bold;
        }

        /* Styling for the message time */
        .message-time {
            color: #888;
            font-size: 12px;
        }
    </style>
@endif

@if ($type == 'customer')
    <style>
        /* Styling for the overall chat container */
        .container-fluid.chats {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .users-list {
            flex: 0.5;
            background-color: #f2f2f2;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Styling for each user in the list */
        .user {
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .user:hover {
            background-color: #e0e0e0;
        }

        .user:last-child {
            border-bottom: none;
        }

        /* Styling for the chat box on the right side */
        .chat-box {
            flex: 2;
        }

        /* Styling for the chat container */
        .chat-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }

        /* Styling for messages */
        .message {
            max-width: 70%;
            padding: 10px;
            border-radius: 8px;
        }

        /* Styling for messages */
        .message-text {
            margin-bottom: 0px;
        }

        /* Styling for admin messages */
        .admin-message {
            background-color: #f2f2f2;
            align-self: flex-start;
        }

        /* Styling for customer messages */
        .customer-message {
            background-color: #DCF8C6;
            align-self: flex-end;
        }

        /* Styling for the username */
        .username {
            font-weight: bold;
        }

        /* Styling for the message time */
        .message-time {
            color: #888;
            font-size: 12px;
        }
    </style>
@endif
