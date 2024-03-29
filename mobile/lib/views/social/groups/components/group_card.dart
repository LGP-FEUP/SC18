import 'package:erasmus_helper/services/group_service.dart';
import 'package:erasmus_helper/views/social/groups/group_page.dart';
import 'package:flutter/material.dart';

class GroupCard extends StatelessWidget {
  final String groupId;

  const GroupCard({Key? key, required this.groupId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.wait([
        GroupService.getGroupImage(groupId),
        GroupService.getGroupTitle(groupId)
      ]),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            List data = response.data as List;
            String image = data[0].toString();
            String title = data[1].toString();
            return _genCard(context, image, title);
          }
        }
        return Container();
      },
    );
  }

  Widget _genCard(BuildContext context, String image, String title) {
    return GestureDetector(
        onTap: () => _navigateToGroupPage(context),
        child: Card(
            elevation: 5,
            child: Stack(
              alignment: Alignment.topCenter,
              children: [
                Row(
                  children: [_genGroupImage(image)],
                ),
                Positioned(
                    top: 150, child: Row(children: [_genGroupInfo(title)]))
              ],
            )));
  }

  Widget _genGroupImage(String image) {
    return Container(
      height: 170,
      width: 252,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(5),
        image: DecorationImage(
          fit: BoxFit.fill,
          image: NetworkImage(
            image,
          ),
        ),
      ),
    );
  }

  Widget _genGroupInfo(String title) {
    return Container(
        width: 252,
        height: 50,
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(5), color: Colors.white),
        alignment: Alignment.centerLeft,
        child: Padding(
          padding: const EdgeInsets.only(left: 5),
          child: Text(title,
              textAlign: TextAlign.end,
              style:
                  const TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
        ));
  }

  void _navigateToGroupPage(BuildContext context) {
    Navigator.push(context,
        MaterialPageRoute(builder: (context) => GroupPage(groupId: groupId)));
  }
}
