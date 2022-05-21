import 'package:flutter/material.dart';

class ForumPost extends StatelessWidget {
  const ForumPost({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    const pic =
        "https://static.vecteezy.com/system/resources/previews/000/671/117/original/triangle-polygon-background-vector.jpg";
    return Padding(
        padding: const EdgeInsets.all(10),
        child: _genPost(
            userPic: pic,
            name: "Ananachos",
            text: "This is a post",
            time: "4h ago",
            postImage: pic));
  }

  Widget _genPost(
      {required String userPic,
      required String name,
      required String text,
      required String time,
      String postImage = ''}) {
    return Container(
      margin: const EdgeInsets.only(bottom: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[_genUserInfo(name, userPic, time)],
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
    );
  }

  Row _genUserInfo(String name, String userPic, String time) {
    return Row(
      children: <Widget>[
        _genUserPic(userPic),
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

  Container _genUserPic(String pic) {
    return Container(
      width: 50,
      height: 50,
      decoration: BoxDecoration(
          shape: BoxShape.circle,
          image: DecorationImage(image: NetworkImage(pic), fit: BoxFit.cover)),
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
