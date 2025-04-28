# 8Chat
Minimal chat application that all text message disappear after 8 hours.
# Database Design
Entities

User (<ins>User ID</ins>, Email, Display name, First name, Last name) 

User_Login (<ins>User ID</ins>, Email, IP Address)

Group (<ins>Group ID</ins>, Group Name, Color code,Group Name2, Color code2,Group Name3, Color code3)

Participate (<ins>Part ID</ins>, User ID, Group ID)

Message (<ins>Msg ID</ins>, Group_ID, Text, Timestamp)

# Limitation
"Group name" can change 3 times
