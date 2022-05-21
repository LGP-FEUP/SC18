import 'package:erasmus_helper/views/social/components/forum_post.dart';
import 'package:flutter/material.dart';

import '../app_topbar.dart';

class ForumPage extends StatelessWidget {
  const ForumPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AppTopBar(
        title: "Forum",
        body: Stack(
          fit: StackFit.expand,
          children: [
            _genCover(),
            _genPostsList()
          ],
        ));
  }

  Widget _genCover() {
    return Stack(children: <Widget>[
      Container(
        decoration: const BoxDecoration(
            image: DecorationImage(
                image: NetworkImage(
                    "https://static.vecteezy.com/system/resources/previews/000/671/117/original/triangle-polygon-background-vector.jpg"),
                fit: BoxFit.cover)),
        height: 170.0,
      ),
      _genTitle(),
    ]);
  }

  Widget _genTitle() {
    final gradient = BoxDecoration(
      gradient: LinearGradient(
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
        colors: <Color>[
          Colors.black.withAlpha(0),
          Colors.black26,
          Colors.black87
        ],
      ),
    );

    return Container(
      height: 170,
      alignment: Alignment.bottomLeft,
      decoration: gradient,
      child: const Padding(
        padding: EdgeInsets.all(5),
        child: Text(
          'Karting',
          style: TextStyle(color: Colors.white, fontSize: 20.0),
        ),
      ),
    );
  }

  Widget _genPostsList() {
    return DraggableScrollableSheet(
      initialChildSize: 0.75,
      minChildSize: 0.75,
      builder: (BuildContext context, ScrollController scrollController) {
        return Container(
          color: Colors.white,
          child: ListView.builder(
            controller: scrollController,
            itemCount: 25,
            itemBuilder: (BuildContext context, int index) {
              return const ForumPost();
            },
          ),
        );
      },
    );
  }
}
