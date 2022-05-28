import 'package:erasmus_helper/services/user_service.dart';
import 'package:flutter/material.dart';
import 'package:jiffy/jiffy.dart';

import '../../../../models/post.dart';

class GroupPost extends StatelessWidget {
  final PostModel post;

  const GroupPost({Key? key, required this.post}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: UserService.getUserName(post.author),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              return _genPost(
                  name: response.data.toString(),
                  text: post.body != null ? post.body! : '',
                  time: post.time);
            }
            return Container();
          }
          return Container();
        });
  }

  Widget _genPost(
      {required String name,
      required String text,
      required int time,
      String postImage = ''}) {
    String timeAgo = Jiffy(DateTime.fromMillisecondsSinceEpoch(time)).fromNow();

    return Card(
      child: Padding(
        padding: const EdgeInsets.all( 10),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: <Widget>[_genUserInfo(name, timeAgo)],
            ),
            const SizedBox(
              height: 20,
            ),
            _genPostText(text),
            const SizedBox(
              height: 20,
            ),
            _genPostImage(postImage),
            const SizedBox(
              height: 20,
            ),
            _genInteractiveButtons()
          ],
        ),
      ),
    );
  }

  Row _genUserInfo(String name, String time) {
    return Row(
      children: <Widget>[
        const CircleAvatar(
          backgroundImage: AssetImage("assets/avatar.jpg"),
          radius: 25,
        ),
        const SizedBox(
          width: 10,
        ),
        Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            Text(
              name,
              style: TextStyle(
                  color: Colors.grey[900],
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1),
            ),
            const SizedBox(
              height: 3,
            ),
            Text(
              time,
              style: const TextStyle(fontSize: 15, color: Colors.grey),
            ),
          ],
        )
      ],
    );
  }

  Text _genPostText(String text) {
    return Text(
      text,
      style: TextStyle(
          fontSize: 15,
          color: Colors.grey[800],
          height: 1.5,
          letterSpacing: .7),
    );
  }

  Container _genPostImage(String postImage) {
    if (postImage != '') {
      return Container(
        height: 200,
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(10),
            image: DecorationImage(
                image: NetworkImage(postImage), fit: BoxFit.cover)),
      );
    }
    return Container();
  }

  Row _genInteractiveButtons() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceAround,
      children: <Widget>[
        _genButton(text: "Like", icon: Icons.favorite, isActive: true),
        _genButton(text: "Comment", icon: Icons.chat)
      ],
    );
  }

  Widget _genButton(
      {required String text, required IconData icon, bool isActive = false}) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 5),
      child: Center(
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Icon(icon, color: isActive ? Colors.red : Colors.grey, size: 18),
            const SizedBox(
              width: 5,
            ),
            Text(
              text,
              style: const TextStyle(color: Colors.grey),
            )
          ],
        ),
      ),
    );
  }
}
