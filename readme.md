# LaraBlog
## LaraBlog is a blog where users can share their thoughts and experiences with others and get reacts and feedbacks
### Features
    - Authintication: users can register, login and logout
    - Authorization: admin has privileges over the users
        Admin:
            - manage all users (can block any user for a certain time)
            - manage posts (can hide or remove any post that breaks the rules)
        User:
            - can create, edit or delete a post
            - can react on other users posts (with like or comment)
    - Notifications: users notified about reactions on their posts
    - Posts
    - Likes
    - Comments
### Installation
```
php artisan key generate
php artisan migrate
php artisan serve

npm install
```
