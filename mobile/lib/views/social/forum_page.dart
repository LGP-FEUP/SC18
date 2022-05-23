import 'package:erasmus_helper/views/social/components/forum_post.dart';
import 'package:flutter/material.dart';

import '../../models/post.dart';
import '../../services/group_service.dart';
import '../app_topbar.dart';

class ForumPage extends StatefulWidget {
  const ForumPage({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _ForumPageState();
  }
}

class _ForumPageState extends State<ForumPage> {
  List<PostModel> posts = [];

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: GroupService.getGroupPosts("karting"),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              posts = response.data as List<PostModel>;
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
            return _genCover();
          }
          return _genCover();
        });
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
            itemCount: posts.length,
            itemBuilder: (BuildContext context, int index) {
              return ForumPost(post: posts[index]);
            },
          ),
        );
      },
    );
  }
}
